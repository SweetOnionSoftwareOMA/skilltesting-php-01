        <div class="col-md-8 ml-auto mr-auto">
        	<h2 class="text-center">Login Activity</h2>
        	<p class="text-center">
        		This data is provided to you to ensure your account is secure and no unauthorized use has occured.
        	</p>
        </div>
        <div class="row mt-5">
        	<div class="col-md-12">
        		<div class="card">
        			<div class="card-body">
        				<div class="toolbar">
        					<!--        Here you can write extra buttons/actions for the toolbar              -->
        				</div>
        				<table id="datatable" class="table table-striped">
        					<thead>
        						<tr>
        							<th>Date/Time UTC</th>
        							<th>Result</th>
        							<th>Impersinated</th>
        							<th>IP Address</th>
        						</tr>
        					</thead>
        					<tbody>
								<?php foreach ($logins->result() as $login): ?>
									<tr>
										<td><?= $login->activity_time ?></td>
										<td><?= $login->status ?></td>
										<td><?= $login->impersonate_user ?></td>
										<td><?= $login->ipaddress ?></td>
									</tr>
								<?php endforeach; ?>
        					</tbody>

        				</table>
        			</div>
        			<!-- end content-->
        		</div>
        		<!--  end card  -->
        	</div>
        	<!-- end col-md-12 -->
        </div>
