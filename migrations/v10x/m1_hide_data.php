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

namespace noordo\hide\migrations\v10x;

use phpbb\db\migration\container_aware_migration;
use noordo\hide\includes\helper as hide_helper;

class m1_hide_data extends container_aware_migration
{
    /** @var hide_helper */
    protected $hide = null;

    /**
     * Install BBCode in database.
     *
     * @return array
     */
    public function update_data()
    {
        return [
            [
                'custom',
                [
                    [$this->get_helper(), 'install_bbcode']
                ]
            ]
        ];
    }

    /**
     * Uninstall BBCode from database (lors de revert de migration).
     *
     * @return array
     */
    public function revert_data()
    {
        return [
            [
                'custom',
                [
                    [$this->get_helper(), 'uninstall_bbcode']
                ]
            ]
        ];
    }

    /**
     * Hide helper.
     *
     * @return hide_helper
     */
    private function get_helper()
    {
        if (!isset($this->hide))
        {
            $this->hide = new hide_helper(
                $this->container->get('dbal.conn'),
                $this->container->get('filesystem'),
                $this->container->get('language'),
                $this->container->getParameter('core.root_path'),
                $this->container->getParameter('core.php_ext')
            );
        }

        return $this->hide;
    }
}
