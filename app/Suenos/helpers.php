<?php

function errors_for($attribute, $errors)
{
    return $errors->first($attribute,'<span class="error label label-warning">:message</span>');
}

function link_to_profile($text = 'Profile')
{
    return link_to_route('profile', $text, Auth::user()->username,['class'=>'btn-profile']);
}
function link_to_payments($text = 'Pagos')
{
    return link_to_route('payments.index', $text,null,['class'=>'btn-payments']);
}

function get_depth($depth)
{
    return str_repeat('<span class="depth">—</span>', $depth);
}

function money($amount, $symbol = '$')
{
    return (!$symbol) ? number_format($amount, 0, ".", ",") : $symbol . number_format($amount, 0, ".", ",");
}
function number($amount)
{
    return preg_replace("/([^0-9\\.])/i", "", $amount);
}
function percent($amount, $symbol = '%')
{
    return $symbol . number_format($amount, 0, ".", ",");
}
function build_tree($arrs, $parent_id=0, $level=0) {
    $tree = '';
   // $ret = '<ul>';
   // dd($arrs);
    foreach ($arrs as $arr) {
        if ($arr['parent_id'] == $parent_id) {
            $tree .= str_repeat("-", $level)." ".$arr['username']."<br />";
            build_tree($arrs, $arr['id'], $level+1);
        }
    }
    return $tree;
}