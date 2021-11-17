<?php $custom_functions = array( "dateDiff", "doBlock", "doCheck", "doColumnHide", "doColumnShow", "doConcat", "doDivide", "doHide", "doJumpForward", "doMax", "doMin", "doMinus", "doMultiply", "doPlus", "doRowHide", "doRowShow", "doShow", "doUnblock", "doUncheck", "endSurvey", "getDistricts", "getLabel", "getStates", "getVal", "gps", "isAlpha", "isAlphaNum", "isFixed", "isMobile", "isNum", "isRange", "isRequired", "msg", "now", "openBox", "random", "setQtext", "setVal", "skip", "toCaps", "today", "toFocus" ); ?>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Pre Proc</a> </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <div class="panel-body">
        <fieldset class="preproc">
          <fieldset class="nonconditional">
            <legend>Non Conditional</legend>
            <ul class="variables">
            </ul>
            <fieldset class="functions">
              <legend>
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Insert Functions</a>
              <ul class="dropdown-menu scrollable-menu">
                <?php foreach($custom_functions as $cf){ ?>
                <li><a class="add-function" href="javascript:void(0)" data-function="<?php echo $cf; ?>"><?php echo $cf; ?></a></li>
                <?php } ?>
              </ul>
              </legend>
            </fieldset>
          </fieldset>
          <fieldset class="conditional">
            <legend>Conditional <a href="javascript:void(0)" class="add-conditional" title="Enable Conditional"><i class="fa fa-plus"></i></a> <a href="javascript:void(0)" class="remove-conditional" title="Disable Conditional"><i class="fa fa-times"></i></a> </legend>
          </fieldset>
        </fieldset>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Post Proc</a> </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
        <fieldset class="postproc">
          <fieldset class="nonconditional">
            <legend>Non Conditional</legend>
            <ul class="variables">
            </ul>
            <fieldset class="functions">
              <legend>
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Insert Functions</a>
              <ul class="dropdown-menu scrollable-menu">
                <?php foreach($custom_functions as $cf){ ?>
                <li><a class="add-function" href="javascript:void(0)" data-function="<?php echo $cf; ?>"><?php echo $cf; ?></a></li>
                <?php } ?>
              </ul>
              </legend>
            </fieldset>
          </fieldset>
          <fieldset class="conditional">
            <legend>Conditional <a href="javascript:void(0)" class="add-conditional" title="Enable Conditional"><i class="fa fa-plus"></i></a> <a href="javascript:void(0)" class="remove-conditional" title="Disable Conditional"><i class="fa fa-times"></i></a> </legend>
          </fieldset>
        </fieldset>
      </div>
      </div>
    </div>
  </div>
</div>
