<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'page');

$variantParent = $activePage->getVariantParent();
$subheader = ($variantParent) ? '<div><span class="small">' . $view['translator']->trans('mautic.page.header.editvariant', [
    '%name%' => $activePage->getTitle(),
    '%parent%' => $variantParent->getTitle()
]) . '</span></div>' : '';

$header = ($activePage->getId()) ?
    $view['translator']->trans('mautic.page.header.edit',
        ['%name%' => $activePage->getTitle()]) :
    $view['translator']->trans('mautic.page.header.new');

$view['slots']->set("headerTitle", $header.$subheader);

$template = $form['template']->vars['data'];

$attr = $form->vars['attr'];
$attr['data-submit-callback-async'] = "clearThemeHtmlBeforeSave";
?>

<?php echo $view['form']->start($form, ['attr' => $attr]); ?>
<!-- start: box layout -->
<div class="box-layout">
    <!-- container -->
    <div class="col-md-9 bg-white height-auto">
        <div class="row">
            <div class="col-xs-12">
                <!-- tabs controls -->
                <ul class="bg-auto nav nav-tabs pr-md pl-md">
                    <li class="active"><a href="#theme-container" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.page.page'); ?></a></li>
                    <li class=""><a href="#source-container" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.core.content'); ?></a></li>
                </ul>

                <!--/ tabs controls -->
                <div class="tab-content pa-md">
                    <div class="tab-pane fade in active bdr-w-0" id="theme-container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $view['form']->row($form['template']); ?>
                            </div>
                        </div>

                        <?php echo $view->render('MauticCoreBundle:Helper:theme_select.html.php', [
                            'type'   => 'page',
                            'themes' => $themes,
                            'active' => $form['template']->vars['value']
                        ]); ?>
                    </div>

                    <div class="tab-pane fade bdr-w-0" id="source-container">
                        <div class="row">
                            <div class="col-md-12" id="customHtmlContainer" style="min-height: 325px;">
                                <?php echo $view['form']->row($form['customHtml']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 bg-white height-auto bdr-l">
        <div class="pr-lg pl-lg pt-md pb-md">
            <?php echo $view['form']->row($form['title']); ?>
            <?php if (!$isVariant): ?>
            <?php echo $view['form']->row($form['alias']); ?>
            <?php else: ?>
            <?php echo $view['form']->row($form['template']); ?>
            <?php endif; ?>
            <?php
            if ($isVariant):
            echo $view['form']->row($form['variantSettings']);

            else:
            echo $view['form']->row($form['category']);
            echo $view['form']->row($form['language']);
            echo $view['form']->row($form['translationParent']);
            endif;

            echo $view['form']->row($form['isPublished']);
            echo $view['form']->row($form['publishUp']);
            echo $view['form']->row($form['publishDown']);

            if (!$isVariant):
            echo $view['form']->row($form['redirectType']);
            echo $view['form']->row($form['redirectUrl']);
            endif;
            ?>

            <div class="template-fields<?php echo (!$template) ? ' hide"' : ''; ?>">
                <?php echo $view['form']->row($form['metaDescription']); ?>
            </div>

            <div class="hide">
                <?php echo $view['form']->rest($form); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $view['form']->end($form); ?>

<?php echo $view->render('MauticCoreBundle:Helper:builder.html.php', [
    'type'          => 'page',
    'sectionForm'   => $sectionForm,
    'builderAssets' => $builderAssets,
    'slots'         => $slots,
    'objectId'      => $activePage->getSessionId()
]); ?>
