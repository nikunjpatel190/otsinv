<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                    <th>Process  Name</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if(count($rsMapDtl)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="14" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($rsMapDtl as $arrRecord)
                    {
                   
					   $proc_id = $arrRecord['proc_id'];
					   $searchCriteria['p_id'] = $proc_id;
					   $searchCriteria['orderField'] = "map.seq";
					   $searchCriteria['selectField'] = "map.stage_id , map.seq , sm.ps_name , pm.proc_name , pm.proc_id";
					   $this->process_model->searchCriteria=$searchCriteria;
					   $data["rsEdit"] = $this->process_model->getProcessStage();
					   
					   $stage_list = $data["rsEdit"];
					
					    $checked = '';
						if($arrRecord['map']=='1')
						{
							$checked = 'checked';
						}
						echo '<tr>';
						echo '<td>'.$arrRecord['proc_name']."</td><td>" ;?>
						
						<?php 
						foreach($stage_list as $arrStageList){
						echo "<span class='label  label-info arrowed-in-left arrowed-in arrowed-right'>".$stage_list = $arrStageList['ps_name']." </span>";
						}
						?>
						<?php echo '</td>';
						echo '<td class="span1 center"><div class="control-group">
								<div class="controls">
									<input type="checkbox" name="switch-field-1" class="ace-switch ace-switch-6 asn" '.$checked.' prodid='.$prod_id.' procid='.$arrRecord['proc_id'].'>
									<span class="lbl"></span>
								</div>
							</div></td>';
                        echo '</tr>';
                    }
				}
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	$(".asn").click(function(){
		var param = {};
		param["prodid"] = $(this).attr('prodid');
		param["procid"] = $(this).attr('procid');
		param["status"] = $(this).is(":checked")?"ACTIVE":"DEACTIVE";

		$.ajax({
			type:"POST",
			url:"index.php?c=commonajax&m=mapProdProcess",
			data:param,
			beforeSend:function(){

			},
			success:function(res){
				
			}
		});
	});
</script>