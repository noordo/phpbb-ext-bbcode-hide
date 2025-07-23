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

namespace noordo\hide\includes;

use phpbb\db\driver\factory as database;
use phpbb\filesystem\filesystem;
use phpbb\language\language;

class helper
{
    /** @var database */
    protected $db;
    /** @var filesystem */
    protected $filesystem;
    /** @var language */
    protected $language;
    /** @var string */
    protected $root_path;
    /** @var string */
    protected $php_ext;
    /** @var \acp_bbcodes */
    protected $acp_bbcodes;

    public function __construct(database $db, filesystem $filesystem, language $language, $root_path, $php_ext)
    {
        $this->db = $db;
        $this->filesystem = $filesystem;
        $this->language = $language;
        $this->root_path = $root_path;
        $this->php_ext = $php_ext;
    }

public function bbcode_data()
{
    $xsl = $this->filesystem->realpath(
        __DIR__ . '/../styles/all/template/hide.xsl'
    );
    $template = $this->filesystem->is_readable($xsl) ? trim(file_get_contents($xsl)) : '';
    if (empty($template))
    {
        return [];
    }

    return [
        'bbcode_tag'        => 'hide',
        // Un seul paramètre
        'bbcode_match'      => '[hide={IDENTIFIER;optional}]{TEXT}[/hide]',
        'bbcode_tpl'        => $template,
        'bbcode_helpline'   => 'HIDE_HELPLINE',
        'display_on_posting'=> 1
    ];
}


    public function remove_feed_bbcode($text)
    {
        return preg_replace('#\[hide(?:=[^\]]+)?\](.*?)\[/hide\]#is', '$1', $text);
    }

    public function install_bbcode()
    {
        $data = $this->bbcode_data();
        if (empty($data))
        {
            return;
        }
        // Lazy load  BBCodes helper
        if (!isset($this->acp_bbcodes))
        {
            if (!class_exists('acp_bbcodes'))
            {
                include($this->root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
            }
            $this->acp_bbcodes = new \acp_bbcodes;
        }
        // Remove conflicting BBCode
        $this->remove_bbcode('hide=');

        $data['bbcode_id'] = (int) $this->bbcode_id();
        $data = array_replace(
            $data,
            $this->acp_bbcodes->build_regexp(
                $data['bbcode_match'],
                $data['bbcode_tpl']
            )
        );
        // Get old BBCode ID
        $old_bbcode_id = (int) $this->bbcode_exists($data['bbcode_tag']);
        // Update or add BBCode
        if ($old_bbcode_id > NUM_CORE_BBCODES)
        {
            $this->update_bbcode($old_bbcode_id, $data);
        }
        else
        {
            $this->add_bbcode($data);
        }
    }

    public function uninstall_bbcode()
    {
        $this->remove_bbcode('hide');
    }

    public function bbcode_exists($bbcode_tag = '')
    {
        if (empty($bbcode_tag))
        {
            return -1;
        }
        $sql = 'SELECT bbcode_id
            FROM ' . BBCODES_TABLE . '
            WHERE ' . $this->db->sql_build_array('SELECT', ['bbcode_tag' => $bbcode_tag]);
        $result = $this->db->sql_query($sql);
        $bbcode_id = (int) $this->db->sql_fetchfield('bbcode_id');
        $this->db->sql_freeresult($result);
        // Set invalid index if BBCode doesn't exist to avoid
        // getting the first record of the table
        $bbcode_id = $bbcode_id > NUM_CORE_BBCODES ? $bbcode_id : -1;
        return $bbcode_id;
    }

    public function bbcode_id()
    {
        $sql = 'SELECT MAX(bbcode_id) as last_id
            FROM ' . BBCODES_TABLE;
        $result = $this->db->sql_query($sql);
        $bbcode_id = (int) $this->db->sql_fetchfield('last_id');
        $this->db->sql_freeresult($result);
        $bbcode_id += 1;
        if ($bbcode_id <= NUM_CORE_BBCODES)
        {
            $bbcode_id = NUM_CORE_BBCODES + 1;
        }
        return $bbcode_id;
    }

    public function add_bbcode($data = [])
    {
        if (empty($data) ||
            (!empty($data['bbcode_id']) && (int) $data['bbcode_id'] > BBCODE_LIMIT))
        {
            return;
        }
        $sql = 'INSERT INTO ' . BBCODES_TABLE . '
            ' . $this->db->sql_build_array('INSERT', $data);
        $this->db->sql_query($sql);
    }

    public function remove_bbcode($bbcode_tag = '')
    {
        if (empty($bbcode_tag))
        {
            return;
        }
        $bbcode_id = (int) $this->bbcode_exists($bbcode_tag);
        // Remove only if exists
        if ($bbcode_id > NUM_CORE_BBCODES)
        {
            $sql = 'DELETE FROM ' . BBCODES_TABLE . '
                WHERE bbcode_id = ' . $bbcode_id;
            $this->db->sql_query($sql);
        }
    }

    public function update_bbcode($bbcode_id = -1, $data = [])
    {
        $bbcode_id = (int) $bbcode_id;
        if ($bbcode_id <= NUM_CORE_BBCODES || empty($data))
        {
            return;
        }
        unset($data['bbcode_id']);
        $sql = 'UPDATE ' . BBCODES_TABLE . '
            SET ' . $this->db->sql_build_array('UPDATE', $data) . '
            WHERE bbcode_id = ' . $bbcode_id;
        $this->db->sql_query($sql);
    }
}
