<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
 <div class="card data-grid-container container-fluid">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'color_set', 'controls' => 'false']); ?>
    </div>
    <div class="card-block">
        <div class="data-grid table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-default">
                    <tr>
                        <th>
                            Set Name
                        </th>
                        <th>
                            Combination
                        </th>
                        <th class="header-action hidden-print"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($colorSetAvailable as $option): ?>
                        <tr>
                            <td><?= $option ?></td>
                            <td>
                                <ul class="list-group color-set color-set__<?= $option ?>">
                                    <li class="list-group-item color-set__<?= $option ?>__list1"></li>
                                    <li class="list-group-item color-set__<?= $option ?>__list2"></li>
                                    <li class="list-group-item color-set__<?= $option ?>__list3"></li>
                                </ul>
                            </td>
                            <td class="icon-action hidden-print">
                                <input type="radio" name="colorset" value="<?= $option ?>" id="option1" autocomplete="off" 
                                    ng-click="saveColorSet('<?= $option ?>')" ng-checked="'<?= $colorSet["colorSet"] ?>' == '<?= $option ?>'">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>  
    </div>
    <div class="card-footer hidden-print">
        <div class="row">   
            <div >
                
            </div>
        </div>
    </div>
</div>