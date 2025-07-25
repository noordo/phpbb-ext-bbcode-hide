<?php

/**
 * Extension "[Hide] avancé" pour phpBB.
 * @author Noordo <https://github.com/noordo>
 * @copyright 2025 Noordo
 * @license GPL-2.0-only
 *
 * Adaptation de l'extension "Hide extension for phpBB"
 * d'Alfredo Ramos <alfredo.ramos@proton.me>
 * @copyright 2017 Alfredo Ramos
**/

namespace noordo\hide\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use noordo\hide\includes\helper;
use phpbb\db\driver\factory as database;
use phpbb\auth\auth;
use phpbb\request\request_interface;
use phpbb\user;

class listener implements EventSubscriberInterface
{
        /** @var helper */
        protected $helper;

       /** @var database */
       protected $db;

       /** @var auth */
       protected $auth;

       /** @var request_interface */
       protected $request;

       /** @var user */
       protected $user;

	/**
	 * Listener constructor.
	 *
	 * @param helper $helper
	 *
	 * @return void
	 */
       public function __construct(helper $helper, database $db, auth $auth, request_interface $request, user $user)
       {
               $this->helper = $helper;
               $this->db = $db;
               $this->auth = $auth;
               $this->request = $request;
               $this->user = $user;
       }

	/**
	 * Assign functions defined in this class to event listeners in the core.
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
               return [
                       'core.user_setup' => 'user_setup',
                       'core.text_formatter_s9e_configure_after' => 'configure_hide',
                       'core.feed_modify_feed_row' => 'clean_feed',
                       'core.text_formatter_s9e_render_before' => 'set_parameters'
               ];
       }

	/**
	 * Load language files and modify user data on every page.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'noordo/hide',
			'lang_set'	=> 'posting'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Add BBCode.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function configure_hide($event)
	{
		$configurator = $event['configurator'];
		$hide = $this->helper->bbcode_data();

		if (empty($hide))
		{
			return;
		}

		// Remove previous definitions
		unset(
			$configurator->BBCodes[$hide['bbcode_tag']],
			$configurator->tags[$hide['bbcode_tag']]
		);

		// Create HIDE BBCode
		$configurator->BBCodes->addCustom(
			$hide['bbcode_match'],
			$hide['bbcode_tpl']
		);
	}

	/**
	 * Remove BBCode from feeds.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
        public function clean_feed($event)
        {
                $event['row'] = array_merge($event['row'], [
                        $event['feed']->get('text') => $this->helper->remove_feed_bbcode(
                                $event['row'][$event['feed']->get('text')]
                        )
                ]);
        }

       /**
        * Set renderer parameters.
        *
        * @param object $event
        *
        * @return void
        */
       public function set_parameters($event)
       {
               $renderer = $event['renderer'];

               $topic_id = $this->request->variable('t', 0);

               // When only a post id is present get the topic id
               if (!$topic_id)
               {
                       $post_id = $this->request->variable('p', 0);

                       if ($post_id)
                       {
                               $sql = 'SELECT topic_id FROM ' . POSTS_TABLE . '
                                       WHERE post_id = ' . (int) $post_id;
                               $result = $this->db->sql_query_limit($sql, 1);
                               $topic_id = (int) $this->db->sql_fetchfield('topic_id', false, $result);
                               $this->db->sql_freeresult($result);
                       }
               }
               $has_posted = false;

               if ($this->user->data['user_id'] && $topic_id)
               {
                       $sql = 'SELECT 1 FROM ' . POSTS_TABLE . '
                               WHERE topic_id = ' . (int) $topic_id . '
                               AND poster_id = ' . (int) $this->user->data['user_id'];
                       $result = $this->db->sql_query_limit($sql, 1);
                       $has_posted = (bool) $this->db->sql_fetchrow($result);
                       $this->db->sql_freeresult($result);
               }
                if (method_exists($renderer, 'get_renderer'))
                {
                        $real_renderer = $renderer->get_renderer();

                        if (method_exists($real_renderer, 'setParameter'))
                        {
                                $real_renderer->setParameter('S_HAS_POSTED', $has_posted);
                                $real_renderer->setParameter('S_IS_ADMIN', $this->auth->acl_get('a_'));
                        }
                }
                elseif (method_exists($renderer, 'setParameter'))
                {
                        $renderer->setParameter('S_HAS_POSTED', $has_posted);
                        $renderer->setParameter('S_IS_ADMIN', $this->auth->acl_get('a_'));
                }
                elseif (property_exists($renderer, 'params'))
                {
                        $renderer->params['S_HAS_POSTED'] = $has_posted;
                        $renderer->params['S_IS_ADMIN'] = $this->auth->acl_get('a_');
                }
       }
}
