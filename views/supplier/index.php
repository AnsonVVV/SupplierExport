<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Alert;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = "Supplier Export by Anson Yim";

$css = <<<CSS
    .csvColumns{margin-left:10px;}
    .hide{display:none;}
    .tips{margin-left:10px;}
    .seleted_tips.nothing{color:#9a9b9b;}
    tbody>tr.checked{
        transition: background-color 0.25s ease-out;
        background-color:#eef8ff !important;
    }
    tbody>tr:hover{
        transition: background-color 0.25s ease-out;
        background-color:#dae6ee !important;
    }
    .pagination {
        /*justify-content: flex-end;*/
    }
    .pagination .prev{border-radius: 5px 0 0 5px;}
    .pagination .next{border-radius: 0 5px 5px 0;}
    .pagination li {
        margin-right: -1px;
        border: 1px solid #007bff;
        cursor: pointer;
    }

    .pagination li:hover {
        transition: background-color 0.25s ease-out;
        background: #007bff;
    }

    .pagination li:hover a {
        transition: color 0.25s ease-out;
        color: #fff;
    }

    .pagination li.disabled {
        cursor: no-drop;
        background: #f5f5f5;
    }

    .pagination li.disabled span {
        color: gray;
    }

    /*.pagination li.disabled*/
    .pagination li a, .pagination li.disabled span {
        display: block;
        padding: 5px 10px;
    }

    .pagination li.active a {
        background: #007bff;
        color: #fff;
    }
CSS;
$this->registerCss($css);


$script = <<<SCRPIT
$(function(){
    loadCheck()
    $("input[type='checkbox']").on('change',function(){
        loadCurrentPageChecked()
    })
    $("input[name='export_id[]']").on('click',function(){
        event.stopPropagation()
    })
    
    
    $("tr").on('click',function(){
        if($(this).find("input[name='export_id[]']")){
            $(this).find("input[name='export_id[]']").prop("checked",!$(this).find("input[name='export_id[]']").prop("checked"))
            loadCurrentPageChecked()
        }else{
            return false
        }
    })
    
    $(".clear_selected").on("click",function(){

        $("input[name='export_ids']").val('')
            loadCheck()

    })
    
    $(".export_btn").on('click',function(){
        var columns = []
        $("input[name='columns[]']:checkbox").each(function () {
            if ($(this).prop("checked")) {
                columns.push($(this).val())
            }
        });
        var keys = $("input[name='export_ids']").val()
        var sort = getUrlParam('sort')
        if(!sort){
            sort = 'id'
        }
        window.open('/supplier/export?columns='+columns+'&keys='+keys+'&sort='+sort)
       
    })
})
function loadCheck(){
    var keys = $("input[name='export_ids']").val()
    keys = keys.split(",")
    var all_check = 1
    $("input[name='export_id[]']").each(function(){
        if ($.inArray($(this).val(),keys)>-1) { 
            $(this).prop("checked",true)
            $(this).parent().parent().addClass("checked")
        }else{
            $(this).prop("checked",false)
            $(this).parent().parent().removeClass("checked")
            all_check = 0
        }
    })
    if(all_check == 1){
        $("input[name='export_id_all']").prop("checked",true)
    }else{
        $("input[name='export_id_all']").prop("checked",false)
    }
    checkBtn()
}
function getUrlParam(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null) return unescape(r[2]); return false;
}

function loadCurrentPageChecked(){
    var keys = $("#grid-view").yiiGridView("getSelectedRows");
    keys = keys.join(",")
    keys = keys.split(",")
    var old_keys = $("input[name='export_ids']").val()
    if(old_keys.length > 0){
        old_keys = old_keys.split(",")
        keys = old_keys.concat(keys)
    }
    keys = [...new Set(keys)]
    $("input[name='export_id[]']").not("input:checked").each(function(){
        keys.remove($(this).val())
        $(this).parent().parent().removeClass("checked")
    })
    $("input[name='export_id[]']:checked").each(function(){
        $(this).parent().parent().addClass("checked")
    })
    
    keys = keys.filter(s=>$.trim(s).length>0)
    keys = keys.join(",")
    $("input[name='export_ids']").val(keys)
    checkBtn()
}

function checkBtn(){
    var keys = $("input[name='export_ids']").val().split(",")
    keys = keys.filter(s=>$.trim(s).length>0)
    
    if(keys.length == parseInt($("input[name='total']").val())){
        $("#all_select_alert").show()
    }else{
        $("#all_select_alert").hide()
    }
    
    
    if(keys.length>0){
        if($(".seleted_tips").hasClass("nothing")){
            $(".seleted_tips").removeClass("nothing").addClass("text text-success")
        }
        
        $(".seleted_tips").html("You have selected "+keys.length+" conversations.")
        if($("#export").hasClass('disabled')){
            $("#export").removeClass("disabled")
        }
        
        if($(".export_btn").hasClass('disabled')){
            $(".export_btn").removeClass("disabled")
        }
        
        
    }else{
        if(!$(".seleted_tips").hasClass("nothing")){
            $(".seleted_tips").addClass("nothing").removeClass("text text-success").html("You have not selected any data yet.")
        }
        if(!$("#export").hasClass('disabled')){
            $("#export").addClass("disabled")
        }
        if(!$(".export_btn").hasClass('disabled')){
            $(".export_btn").addClass("disabled")
        }
    }
}

Array.prototype.remove = function(val) { 
    var index = this.indexOf(val); 
    if (index > -1) { 
        this.splice(index, 1); 
    }
};
SCRPIT;

?>

<h1>Supplier List</h1>
<?= \yii\bootstrap4\Html::hiddenInput('export_ids') ?>
<?= Alert::widget([
    'options' => [
        'class' => 'alert-primary fade show hide',
        'id' => 'all_select_alert',
    ],
    'closeButton' => false,
    'body' => "All conversations in this search have been selected. <a href='javascript:void(0)' class='clear_selected alert-link'>>>> clear selection <<<</a>",
])
?>

<?php try { ?>
    <?php Pjax::begin(['id' => 'pjax-students-gridview',]);
    $this->registerJs($script); ?>
    <?= \yii\grid\GridView::widget($gridViewConfig) ?>
    <?= \yii\bootstrap4\Html::hiddenInput('total', $total) ?>

    <?php Modal::begin([
        'id' => 'export-modal',
        'title' => '<h4 class="modal-title">Export to CSV</h4>',
        'footer' => '<button type="button" class="btn btn-success disabled export_btn" data-dismiss="modal">Export</button> <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>',
    ]); ?>
    <span class='seleted_tips nothing'>You have not selected any data yet.</span>
    <p class='text text-primary'>Which column(s) to be included in the CSV：</p>
    <div class="clearfix"></div>
    <?= Html::checkbox('columns[]', true, ['label' => 'ID', 'disabled' => true, 'value' => 'id']) ?>
    <?= Html::checkbox('columns[]', true, ['label' => 'Name', 'value' => 'name', 'class' => 'csvColumns']) ?>
    <?= Html::checkbox('columns[]', true, ['label' => 'Code', 'value' => 'code', 'class' => 'csvColumns']) ?>
    <?= Html::checkbox('columns[]', true, ['label' => 'T Status', 'value' => 't_status', 'class' => 'csvColumns']) ?>
    <?php
    Modal::end();
    ?>
    <?php Pjax::end(); ?>


<?php } catch (\yii\base\Exception $e) { ?>
    <div class="jumbotron">
        <h1 class="display-4">Opp...</h1>
        <p class="lead"><?= $e->getMessage() ?></p>
        <a class="btn btn-primary btn-lg" href="<?= Url::to(['supplier/index']) ?>" role="button">Retry</a>
    </div>
<?php } ?>
