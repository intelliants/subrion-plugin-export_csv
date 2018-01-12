<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2015 Intelliants, LLC <http://www.intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link http://www.subrion.org/
 *
 ******************************************************************************/

ini_get('safe_mode') || set_time_limit(180);

$iaView->assign('tooltips', iaLanguage::getTooltips());

$iaItem = $iaCore->factory('item');

if (iaView::REQUEST_JSON == $iaView->getRequestType()) {
    if ('getFields' == $_GET['action']) {
        $itemTable = $iaItem->getItemTable($_GET['item']);

        $output['table'] = $itemTable;
        $columns = $iaCore->iaDb->describe($itemTable);

        foreach ($columns as $column) {
            $output['fields'][] = $column['Field'];
        }

        $iaView->assign($output);
    }
}

if (iaView::REQUEST_HTML == $iaView->getRequestType()) {
    $error = false;
    $messages = array();

    // get list & info of installed packages
    $items_list = $iaItem->getItemsInfo();

    $iaView->assign('items_list', $items_list);

    if (isset($_POST['getFields'])) {
        if (empty($_POST['items'])) {
            $iaView->setMessages(iaLanguage::get('package_error'));
        }
    }

    if (isset($_POST['download'])) {
        if (empty($_POST['fields'])) {
            $error = true;
            $messages[] = iaLanguage::get('fields_error');
        }

        if (empty($_POST['delimeter'])) {
            $error = true;
            $messages[] = iaLanguage::get('delimeter_error');
        }

        if (!$error) {
            $delimeter = $_POST['delimeter'];
            $enclosure = $_POST['enclosure'] ? $_POST['enclosure'] : '"';
            $attachment = false;

            $start = isset($_POST['start']) ? $_POST['start'] : '0';
            $limit = isset($_POST['limit']) ? $_POST['limit'] : '1000';
            $filename = urlencode('data_' . $_POST['items'] . '.' . 'csv');

            if ($data = $iaDb->all($_POST['fields'], '', $start, $limit, $_POST['tableName'])) {
                if ($attachment) {
                    // send response headers to the browser
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename=' . $filename);
                    $csv_file = fopen('php://output', 'w');
                } else {
                    $csv_file = fopen(IA_TMP . $filename, 'w');
                }

                // process records
                foreach ($data as $fields) {
                    $fields = array_map(array('iaSanitize', 'sql'), $fields);
                    fputcsv($csv_file, $fields, $delimeter, $enclosure);
                }
                fclose($csv_file);

                if ($attachment) {
                    $iaView->set('nodebug', 1);
                    $iaView->disableLayout();
                    die();
                } else {
                    $messages[] = iaLanguage::getf('csv_file_generated', array('filename' => IA_CLEAR_URL . 'tmp/' . $filename));
                }
            }
        }

        $iaView->setMessages($messages, ($error ? iaView::ERROR : iaView::SUCCESS));
    }

    $iaView->display();
}
