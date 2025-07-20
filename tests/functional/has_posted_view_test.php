<?php
/**
 * Hide extension for phpBB.
 *
 * @author Alfredo Ramos <alfredo.ramos@proton.me>
 * @copyright 2017 Alfredo Ramos
 * @license GPL-2.0-only
 */

namespace alfredoramos\hide\tests\functional;

/**
 * @group functional
 */
class has_posted_view_test extends \phpbb_functional_test_case
{
        protected function setUp(): void
        {
                parent::setUp();
                $this->add_lang_ext('alfredoramos/hide', 'posting');
        }

        static protected function setup_extensions()
        {
                return ['alfredoramos/hide'];
        }

        public function test_user_posted_can_view_hidden_content()
        {
                $this->login();

                $post = $this->create_topic(
                        2,
                        'Has posted view test',
                        '[hide]Visible text[/hide]'
                );

                $crawler = self::request('GET', sprintf(
                        'viewtopic.php?t=%d&sid=%s',
                        $post['topic_id'],
                        $this->sid
                ));

                $expected = '<section class="hidden-content">'.
                                                '<header><span>'.$this->lang('HIDDEN_CONTENT').'</span></header>'.
                                                'Visible text'.
                                        '</section>';

                $result = $crawler->filter(sprintf(
                        '#post_content%d .content',
                        $post['topic_id']
                ));

                $this->assertSame(1, $result->count());
                $this->assertStringContainsString($expected, $result->html());

                return $post['topic_id'];
        }

        /**
         * @depends test_user_posted_can_view_hidden_content
         */
        public function test_user_without_post_cannot_view_hidden_content($topic_id)
        {
                $this->create_user('user_b');
                $this->login('user_b');

                $crawler = self::request('GET', sprintf(
                        'viewtopic.php?t=%d&sid=%s',
                        $topic_id,
                        $this->sid
                ));

                $expected = '<div class="hidden-content error">'.
                                                $this->lang('HIDDEN_CONTENT_EXPLAIN').
                                        '</div>';

                $result = $crawler->filter(sprintf(
                        '#post_content%d .content',
                        $topic_id
                ));

                $this->assertStringContainsString($expected, $result->html());
        }
}
