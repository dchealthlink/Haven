/*
Author's Notes:

 
 
This generates two structures: a tree and a list of objects. Both are generated from the following standard parent/child database format:


cat_id: primary key, auto_increment 
cat_title: name of category 
cat_parent_id: points to the cat_id of this items parent.

These are two recursive functions that first build a tree structure. The second recursive function builds a sortable list of objects with their full category path as shown below: 
*/


/************************************************************/
// Category Item class

class category_item
{
    var $cat_id;
    var $depth;
    var $cat_title;
    var $cat_parent_id;
    var $cat_long_title;

    function category_item($cat_id, $depth, $cat_title, $cat_parent_id, $cat_long_title = '')
    {
        $this->cat_id = $cat_id;
        $this->depth = $depth;
        $this->cat_title = $cat_title;
        $this->cat_parent_id = $cat_parent_id;
        $this->cat_long_title = $cat_long_title;
    }
}

/*************************************************************/
// Builds the category list for the category select

$list = array();

function build_list($cat_array, $item = '', $depth = 0)
{
    global $template;
    global $list;

    foreach($cat_array as $category)
    {
        $loop_item = "$item$category[cat_title]";

        $category_item = new category_item($category[cat_id], $depth, $category[cat_title], $category[cat_parent_id], $loop_item);
        $list[] = $category_item;

        if(count($category[children]) > 0)
        {
            $depth++;
            build_list($category[children], $loop_item." > ", $depth);
            $depth--;
        }

        $loop_item = '';
    }

    return $list;
}

/*************************************************************/
// Adds the object to the children array of the object with 
// a cat_id equal to $parent_id

function tree_add($tree, $parent_id, $object, $cat_id)
{
    // Only start from the given cat_id, ignore all other roots

    if($parent_id == '0' and $object[cat_id] == $cat_id)
    {
        $tree[$object[cat_id]] = $object;
        return $tree;
    }

    if($tree)
    {
        foreach($tree as $key => $value)
        {
            $current = $tree[$key];

            // If this is the parent, add the object to it's children array
            if($current[cat_id] == $parent_id)
            {
                $tree[$key][children][$object[cat_id]] = $object;
            }
            else
            {
                // If it's not in this level, look a level deeper on the current object.
                $tree[$key][children] = tree_add($current[children], $parent_id, $object, $cat_id);
            }
        }
    }

    return $tree;
}

/*************************************************************/
// This pulls the data from the database.  This will be in your main program
// after you query your database.


        while($category = $db->mysql_fetch_array($result))
        {
            $children = array();

            $category[children] = $children;

            $cat_id = $category[cat_id];
            $cat_parent_id = $category[cat_parent_id];

            $cat_tree = tree_add($cat_tree, $cat_parent_id, $category, $directory_id);
        }

        $cat_list = build_list($cat_tree);

