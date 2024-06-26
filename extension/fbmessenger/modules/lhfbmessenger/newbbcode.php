<?php
$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/newbbcode.tpl.php');

$item = new erLhcoreClassModelFBBBCode();

$tpl->set('item',$item);

if (ezcInputForm::hasPostData()) {

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('fbmessenger/bbcode');
        exit;
    }

    $Errors = erLhcoreClassFBValidator::validateBBCode($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            erLhcoreClassModule::redirect('fbmessenger/bbcode');
            exit ;

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array (
        'url' =>erLhcoreClassDesign::baseurl('fbmessenger/facebook'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook')
    ),
    array (
        'url' =>erLhcoreClassDesign::baseurl('fbmessenger/bbcode'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook BBCodes')
    ),
    array(
        'url' =>erLhcoreClassDesign::baseurl('fbmessenger/newbbcode'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'New BBCode')
    )
);

?>