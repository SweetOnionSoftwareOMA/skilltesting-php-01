			<div class="container-fluid">

				<div class="row">
					<div class="col-lg-12">
						<!-- Search Filters -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Search</h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="container">
									<?php echo form_open('#', array('name' => 'frmChartFilters', 'id' => 'frmChartFilters'));?>
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'reporting_week_start';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => date("Y-W", strtotime($start_date)),
					        								  'class' => 'form-control',
					        								  'tabindex' => '2',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please select Reporting Week.');?>
												<label for="<?php echo $inputName;?>">Start of Reporting Week<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
<?php
												$inputName = 'reporting_week_end';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => date("Y-W", strtotime($end_date)),
					        								  'class' => 'form-control',
					        								  'tabindex' => '2',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please select Reporting Week.');?>
												<label for="<?php echo $inputName;?>">End of Reporting Week<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
										<div class="col-lg-4 col-sm-12">
<?php
										if (sizeof($this->session->userdata('user_offices'))):?>
											<div class="form-group">
												<label for="ddOffices">Offices<sup class="text-danger">*</sup></label>
												<select name="ddOffices[]" id="ddOffices" class="mdb-select select" multiple size="5" style="width:100%;">
<?php
												foreach($this->session->userdata('user_offices') as $key => $value):?>
													<option value="<?php echo $key;?>" selected="selected"><?php echo $value['name'];?></option>
<?php
												endforeach;?>
												</select>
											</div>
<?php
										endif;?>
										</div>
										<div class="col-lg-4 col-sm-12">
											<br><br><br><br>
											<input type="button" class="btn btn-primary btn-block" value="Redraw Charts" id="RedrawChart">
										</div>
									</div>
									<?php echo form_close();?>
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Filters -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Patient Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Patient Data</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="container">
									<div class="row">
										<div class="col-md-6">
							                <div class="text-center text-lg">Patient Encounters</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="patientEncounterChart" data-chart-type="line" data-chart-name="PatientEncounters" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-6">
											<div class="text-center text-lg">New Patient Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="newPatientRateChart" data-chart-type="line" data-chart-name="NewPatientRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-md-6">
							                <div class="text-center text-lg">Retinal Image Acceptance Rates</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="RetinalImageAcceptanceRates" data-chart-type="line" data-chart-name="RetinalImageAcceptanceRates" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-6">
											<div class="text-center text-lg">Authorization Compliance Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="PatientEncounterConversionRate" data-chart-type="line" data-chart-name="PatientEncounterConversionRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->

									<div class="row">
										<div class="col-md-6">
							                <div class="text-center text-lg">Confirmation Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="confirmationRate" data-chart-type="line" data-chart-name="ConfirmationRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-6">
											<div class="text-center text-lg">No Show Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="noShowRate" data-chart-type="line" data-chart-name="NoShowRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->

								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Patient Data -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Revenue Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Revenue Data</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="container">
									<div class="row">
										<div class="col-md-6">
							                <div class="text-center text-lg">Total Practice Cash</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="totalPracticeCash" data-chart-type="bar" data-chart-name="TotalPracticeCash" data-chart-filters="frmChartFilters" data-chart-legend-diplay="false"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-6">
											<div class="text-center text-lg">Cash Collection Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="cashCollectionRate" data-chart-type="line" data-chart-name="CashCollectionRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Revenue Data -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Sales Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Sales Conversions</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="container">
									<div class="row">
										<div class="col-md-6">
							                <div class="text-center text-lg">Contact Lens Conversion Rates</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="contactLensConversionRates" data-chart-type="line" data-chart-name="ContactLensConversionRates" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-6">
											<div class="text-center text-lg">Glasses Conversion Rates</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="glassesConversionRates" data-chart-type="line" data-chart-name="GlassesConversionRates" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Sales Conversions -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Procedure Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Procedure Conversions</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
								</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body p-0">
								<div class="container">
									<div class="row">
										<div class="col-md-4">
							                <div class="text-center text-lg">Neurolens Conversion Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="neurolensConversionRate" data-chart-type="line" data-chart-name="NeurolensConversionRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (LEFT) -->

										<div class="col-md-4">
											<div class="text-center text-lg">Lipiflow Conversion Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="lipiflowConversionRate" data-chart-type="line" data-chart-name="LipiflowConversionRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (CENTER) -->

										<div class="col-md-4">
											<div class="text-center text-lg">Myopia Conversion Rate</div>
											<div class="card card-info">
												<div class="card-body">
													<div class="chart">
														<div class="overlay dark"><i class="fas fa-4x fa-spinner fa-spin"></i></div>
														<canvas id="myopiaConversionRate" data-chart-type="line" data-chart-name="MyopiaConversionRate" data-chart-filters="frmChartFilters" data-chart-legend-diplay="true"></canvas>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
											<!-- /.card -->
										</div>
										<!-- /.col (RIGHT) -->
									</div>
									<!-- /.row -->
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Procedure Conversions -->

			</div><!-- /.container-fluid -->
