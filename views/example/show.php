
<div class="grid_6">
	<div class="block-border">
    	<div class="block-header">
        	<h1>Visualizando Usu&aacute;rio</h1>
    	</div>
        	<table id="" class="table">
            	<tbody>
                	<tr>
						<td width="100px">Sigla</td>				
                        <td><?php echo $venture->acronym; ?></td>
					</tr>
                    
                    <tr class="even" >
						<td>Nome</td>				
                        <td><?php echo $venture->name; ?></td>
					</tr>
                    
                    <tr>
						<td>Modalidade</td>						
                        <td><?php echo $venture->modality; ?></td>
					</tr>
                    
                    <tr class="even" >
						<td>Categoria</td>		
                        <td><?php echo $venture->category; ?></td>
					</tr>
                    
                    <tr>
						<td>Endere&ccedil;o</td>	
                        <td>
                        	<?php echo $venture->street. " " . $venture->lot. ", ". $venture->neighborhood. ", ".$venture->city." - ".$venture->state ?>
                        </td>
					</tr>
                    
                    <tr class="even" >
						<td>Terreno</td>					
                        <td><?php echo $venture->ground; ?></td>
					</tr>
                    
                    <tr>
						<td>Constru&iacute;do</td>					
                        <td><?php echo $venture->built; ?></td>
					</tr>
                    
                    <tr class="even" >
						<td>Unidades</td>					
                        <td><?php echo $venture->units; ?></td>
					</tr>
                    
                    <tr>
						<td>Data lan&ccedil;amento</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->date_release))?></td>
					</tr>
                    
                    <tr class="even" >
						<td>In&iacute;cio da obras</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->date_start))?></td>
					</tr>
                    
                    <tr>
						<td>T&eacute;rmino previsto</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->date_forecast))?></td>
					</tr>
                    
                    <tr class="even" >
						<td>T&eacute;rmino real</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->date_actual_finish))?></td>
					</tr>
                    
                    <tr>
						<td>Data Habite-se</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->date_dwell))?></td>
					</tr>
                    
                    <tr class="even" >
						<td>Criado em</td>					
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->created_at))." ".timestamp_to_time($venture->created_at)?></td>
					</tr>
                    
                    <tr>
						<td>Alterado em</td>				
                        <td><?php echo date_format_DMY(timestamp_to_date($venture->updated_at))." ".timestamp_to_time($venture->updated_at)?></td>
					</tr>
                    
                </tbody>
            </table>

    </div>
</div>