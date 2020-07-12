<?php
// $Id: xigg_121.inc.php,v 1.2 2008/11/16 14:04:22 ohwada Exp $

// 2008-11-16 K.OHWADA
// Xigg 1.21

//================================================================
// What's New Module
// get aritciles from module
// Xigg 1.00 <http://xigg.org/>
// 2008-02-13 onokazu
//================================================================

if (!defined( 'XOOPS_TRUST_PATH' )) exit;

$module_dirname = basename(dirname(__FILE__));

eval('
function ' . $module_dirname . '_new($limit = 0, $offset = 0)
{
	return xigg_whatsnew_base("' . $module_dirname . '", $limit, $offset);
}
');

if (!function_exists('xigg_whatsnew_base')) {
	function xigg_whatsnew_base($module_dirname, $limit = 0, $offset = 0)
	{
//      require XOOPS_TRUST_PATH . '/modules/Xigg/common.php';
		$file_common = XOOPS_TRUST_PATH . '/modules/Xigg/common.php';
		if ( file_exists( $file_common ) ) {
			require $file_common ;
		} else {
			return false;
		}

        $url_base = XOOPS_URL . '/modules/' . $module_dirname . '/index.php';

//      $model =& $xigg->getService('Model');
		$model =& $xigg->locator->getService('Model');

        $node_r =& $model->getRepository('Node');
        $nodes =& $node_r->fetchByCriteria(Sabai_Model_Criteria::createValue('node_hidden', 0), $limit, $offset, array('node_published'), array('DESC'));
        $nodes =& $nodes->with('Category');
        $nodes =& $nodes->with('Tags');
        $nodes->rewind();
        while ($node =& $nodes->getNext()) {
            $cat_name = $cat_link = '';
            if ($node_category =& $node->get('Category')) {
                $cat_name = h($node_category->getLabel());
                $cat_link = Sabai_URL::get('', array('category_id' => $node_category->getId()), '', $url_base);
            }
            $node_tags =& $node->get('Tags');
            $tags = array();
            while ($node_tag =& $node_tags->getNext()) {
                $tags[] = array(
                                   'name' => h($node_tag->getLabel()),
                                   'link' => $node_tag->getLink($url_base),
                                 );
            }
            $ret[] = array(
                            'id' => $node->getId(),
                            'uid' => $node->getUserId(),
                            'title' => h($node->getLabel()),
                            'description' => ($teaser = $node->get('teaser_html')) ? $teaser : $node->get('body_html'),
                            'time' => $node->get('published'),
                            'created' => $node->getTimeCreated(),
                            'issued' => $node->get('published'),
                            'modified' => $node->getTimeUpdated(),
                            'hits' => $node->get('views'),
                            'replies' => $node->getCommentCount(),

//                          'link' => Sabai_URL::get('/node/' . $node->getId(), array(), '', $url_base),
							'link'  => 'index.php/node/' . $node->getId(),

                             'cat_name' => $cat_name,
                            'cat_link' => $cat_link,
                            'tags' => $tags,
                          );
        }
//      print_r($ret);
        return !empty($ret) ? $ret : array();
    }
}

?>