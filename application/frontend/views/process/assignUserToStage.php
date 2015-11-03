<form id="frmAssignUser" name="frmAssignUser">
<input type="hidden" name="processId" id="processId" value="<?php echo $processId; ?>" />
<table width="100%" border="0" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="80%">Stage</th>
            <th width="20%">User</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($resArr AS $key=>$row)
        {
    ?>
            <tr>
                <td>
                    <label id="<?php echo $row['ps_id']; ?>"><?php echo $row['ps_name']; ?></label>
                </td>
                <td align="right">
                    <select name="slt_user<?php echo $row['ps_id']; ?>" id="slt_user<?php echo $row['ps_id']; ?>" class="mltSlt" multiple="multiple">
            <?php echo $this->Page->generateComboByTable("user_master","user_id","user_full_name","","where status='ACTIVE' order by user_full_name","",""); ?>
        </select>
                </td>
            </tr>
    <?php
        }
    ?>
    </tbody>
</table>
</form>

<link rel="stylesheet" href="./css/bootstrap-multiselect.css" />
<script src="./js/bootstrap-multiselect.js"></script>

<!-- Start Initialize multiselect plugin: -->
	<script type="text/javascript">
        $(document).ready(function() {
            $('.mltSlt').multiselect({
			});
        });
    </script>
<!-- End Initialize multiselect plugin: -->