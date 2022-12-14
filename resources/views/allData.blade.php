<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>Maximum Admin - Dashboard  Data Tables</title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="css/vendors_css.css">
	
	
	<!-- Style-->    
	<link rel="stylesheet" href="{{url('css/horizontal-menu.css')}}"> 
	<link rel="stylesheet" href="{{url('css/style.css')}}">
	<link rel="stylesheet" href="{{url('css/skin_color.css')}}">
	<link rel="stylesheet" href="{{url('css/drag_drop.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	
	<!-- toast style -->
	<link rel="stylesheet" href="{{url('css/toastr.min.css')}}" />
	<link rel="stylesheet" href="{{url('css/toastr.css')}}" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{url('js/toastr.min.js')}}"></script>
	
</head>

<body class="layout-top-nav light-skin theme-primary fixed">
	
	<div class="wrapper">
		<!-- <div id="loader"></div> -->
		
		<header class="main-header">
			<h1 style="font-size:4rem;text-align:center;color:white;">All Data</h1>
		</header>
  
		<!-- Left side column. contains the logo and sidebar -->
		
		<div class="content-wrapper">
	  <div class="container-full">
		  
		  <!-- start tables content -->
		  <section class="content" style="margin-bottom:2rem;">
			<div class="row">
				
				
				<div class="col-12">
					<div class="box">
						<div class="box-header">						
							<h4 class="box-title">Email List Data</h4>
							<button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
								Load Data
							</button>
						</div>
					<div class="box-body">
						<div id="listTB" class="table-responsive">
							<table id="adam" class="table table-striped display">
								<thead>
									<tr>
										<th>Name</th>
										<th>ISP</th>
										<th>GEO</th>
										<th>MX</th>
										<th>Fresh</th>
										<th>Clean</th>
										<th>Supp</th>
										<th>Hardb</th>
										<th>Active</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($allEmailLists as $allEmailList)
									<tr>
										<td>{{$allEmailList->first()->list_id}}</td>
										<td>{{$allEmailList->first()->isp_name}}</td>
										<td>{{$allEmailList->first()->geo_name}}</td>
										<td>{{$allEmailList->first()->mx}}</td>
										
										@php $tbls = []; @endphp
										@foreach($allEmailList as $email)
										@php
										
										if (str_contains($email->name, "_fresh"))
										$tbls[0] = $email->mbr;
										
										elseif (str_contains($email->name, "_clean"))
										$tbls[1] = $email->mbr;
										
										elseif (str_contains($email->name, "_supp"))
										$tbls[2] = $email->mbr;
										
										elseif (str_contains($email->name, "_hardb"))
										$tbls[3] = $email->mbr;

												elseif (str_contains($email->name, "_active"))
												$tbls[4] = $email->mbr;
											@endphp
											@endforeach
											
											@php ksort($tbls);  @endphp

											
											@foreach($tbls as $tbl)
											<td>{{$tbl}}</td>
											@endforeach
											
									</tr>
									@endforeach
                                
								</tbody>

						</table>
						</div>
					</div>
					<button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddModal">Add</button>
				</div>
			</div>
			
			

			<div class="col-12">
				<div class="box">
					<div class="box-header">						
						<h4 class="box-title">Status:</h4>
					</div>
					<div class="box-body">
						<div id="div_table_statuts" class="table-responsive">
							<table id="status_tb" class="table table-striped table-bordered display" style="width:100%">
								<thead>
									<tr>
										<th>Domain</th>
										<th>Number</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="tbs_body">
                                
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>
				
			</section>
		
		<!-- end of tables -->
		
		<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Get Data</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<h4>Select a file </h4>
						<div class="drop-zone">
							<span class="drop-zone__prompt">click to upload</span>
							<input id="txt_file_input" type="file" name="myFile" class="btn drop-zone__input">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						<button id="btn_result" type="button" class="btn btn-dark">Get Results</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		
		<!-- modal 2 -->

		<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Email List</h4>
					</div>
					<div class="modal-body">
						<!-- <form action="/insert2" method="post">
							@csrf -->
							
							<input type="hidden" id="domain_selected">
							<input type="hidden" id="file_name">
							
							<div id="containerModal2">
								<table id="adam" class="table table-striped table-bordered display" style="width:100%">
									<thead>
										<tr>
											<th>Name</th>
											<th>ISP</th>
											<th>GEO</th>
											<th>MX</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach ($allEmailLists as $allEmailList)
									
									<tr>
										<td name="email_name">{{$allEmailList->first()->list_id}}</td>
										<td>{{$allEmailList->first()->isp_name}}</td>
										<td>{{$allEmailList->first()->geo_name}}</td>
										<td>{{$allEmailList->first()->mx}}</td>
											
											<td><button id="select_modal" class="btn btn-info" onclick="selectList('{{$allEmailList->first()->list_id}}')">Select</button></td>
										</tr>
										
										@endforeach
										
									</tbody>

								</table>
							</div>
	
						</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>

		<!-- end Modal 2 -->
		
		<!-- strat MODALE 3 ADD ISPS GEOS LISTS-->
		<div id="AddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Get Data</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						
						<!-- LIST -->
						<div id="list_form_container">
							<h2 class="text-center">Email lists Inserting: </h2>
							<br>
							
							<input type="hidden" name="_token" value = "<?php echo csrf_token(); ?>"><input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
							
							<label class="form-group">Name:</label>
							<input id="list_name_form" type="text" class="form-control" autocomplete="false" placeholder="Name" name="name">
							
							<div class="form-group">
								<label class="form-label">ISP:</label>
								<select id="isp_name_form" class="form-control select2" style="width: 100%;" name="isp_id">
									@foreach($isps as $isp)
									<option value="{{$isp->id}}">{{$isp->isp_name}}</option>
									
									@endforeach
								</select>
							</div>
							
							<div class="form-group">
								<label class="form-label">GEO:</label>
								<select id="geo_name_form" class="form-control select2" style="width: 100%;" name="geo_id">
										@foreach($geos as $geo)
										<option value="{{$geo->id}}">{{$geo->geo_name}}</option>
										
										@endforeach
									</select>
							</div>
							
								<label>MX:</label>
								<input type="text" id="mx_form" class="form-control" autocomplete="false" placeholder="Enter mx" name="mx"><br>
								<button onclick="addList()" value = "Add list" class="btn btn-primary">Add List</button>
							</div>

							
						<!-- GEO -->
						<div id="geo_form_container" style="display:none;">
							<h2 class="text-center">Geo Inserting: </h2>
							<br>
							
							<input type="hidden" name="_token" value = "<?php echo csrf_token(); ?>"><input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
							
								<label class="form-group">GEO Name:</label>
								<input type="text" class="form-control" autocomplete="false" placeholder="Name" id="geoName" name="geo_name">
								
								
								<label>Geo Code:</label>
								<input type="text" class="form-control" autocomplete="false" placeholder="Enter Geo Code" id="geoCode" name="geo_code" maxlength="2"><br>
								<button onclick="addGeo()" value = "Add Geo" class="btn btn-primary">Add Geo</button>
							</div>
							
							
							<!-- ISP -->
							<div id="isp_form_container" style="display:none;">
								<h2 class="text-center">Isp Inserting: </h2>
								<br>
								
								<input type="hidden" name="_token" value = "<?php echo csrf_token(); ?>"><input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
								
								<label>ISP Name:</label>
								<input type="text" class="form-control" autocomplete="false" placeholder="Enter Isp Name" id="ispName" name="isp_name"><br>
								<button onclick="addIsp()"  value = "Add isp" class="btn btn-primary">Add Isp</button>
							</div>
						</div>
					<div class="modal-footer">

						<button id="btn_add_geo" type="button" class="btn btn-dark" onclick="showGeo()">Add GEO</button>
						<button id="btn_add_isp" type="button" class="btn btn-dark" onclick="showIsp()">Add ISP</button>
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END MODALE 3 -->
		
	</div>
</div>


<!-- JQUERY AN Toastr -->


<!-- Vendor JS -->
	<script src="{{url('js/myjs.js')}}"></script>
    <script src="{{url('js/vendors.min.js')}}"></script>
    <script src="{{url('js/pages/chat-popup.js')}}"></script>
    <script src="{{url('assets/icons/feather-icons/feather.min.js')}}"></script>	
    <script src="{{url('assets/vendor_components/datatable/datatables.min.js')}}"></script>
    
    <!-- Maximum Admin App -->
    <script src="{{url('js/jquery.smartmenus.js')}}"></script>
    <script src="{{url('js/menus.js')}}"></script>
    <script src="{{url('js/template.js')}}"></script>
	<!-- <script type="module" src="{{url('js/drag_drop.js')}}"></script> -->
    
	
	
	<!-- when you add a table you have to give it a unique id and do the same as bellow -->
	<script>
		var table = $('#adam').DataTable();
		var table_01 = $('#status_tb').DataTable({
			"columns": [
				{ "data": "Domain" },
                { "data": "Number" },
                { "data": "Action" },
            ],
        });
		</script>





<script>
	let btn_input = document.getElementById('unique_input');
		let btn_result = document.getElementById('btn_result');
		let select_modal = document.getElementById('select_modal');
		let fileInput = document.getElementById('txt_file_input');
		var fileName = document.getElementById('file_name').value;
		
		var filePath = fileInput.value;
		
		btn_result.addEventListener('click', () => {
			
			var file = document.getElementById('txt_file_input').value;
			var tbs_body = document.getElementById('tbs_body');
			var reader = new FileReader();
			reader.onload = function() {
			  var text = reader.result;
			  
			  var data = {
					"_token": "{{ csrf_token() }}",
					"file": file,
					"text_file": text,
				};
				
				jQuery.ajax({
					url: "{{url('/testFunction')}}",
					method: "POST",
					data: data,
					success: function(response)
					{
						if(response.success){
							fileName = file;
							
							var table = $("#status_tb").DataTable();
							table.clear().draw();
							
							var obj = response.count;
							
							for(var i in obj)
							{	
								table.row.add({
									"Domain": i,
									"Number": obj[i],
									"Action": `<button onclick='getdomainName("${i.trim()}")' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModal2'>Select</button>`,
								});
							}
							table.draw();
						}else {
							toastr.warning(response.msg);
						}
					},
					error: function(response)
					{
						alert(response.msg);
					}
				});
			};
			//this line of code is necessary to read the txt file
			reader.readAsText(fileInput.files[0]);
		});

		
		
		
		function getdomainName(domainName)
		{
			var data = {
				"_token": "{{ csrf_token() }}",
				"domain": domainName,
			};
			
			
			
			jQuery.ajax({
				url: "{{url('/domainName')}}",
				method: "POST",
				data: data,
				success: function(response)
				{
					document.getElementById("domain_selected").value = domainName;
					$('#containerModal2').load(document.URL +  ' #containerModal2');
				},
				error: function(response)
				{
					toastr.warning("Error !");

				}
			});
				
			}
			
		function selectList(listName)
		{
			domain_selected = document.getElementById("domain_selected").value;
			// console.log(listName);
			// console.log(domain_selected);
			
			
			var data = {
				"_token": "{{ csrf_token() }}",
				"domain": domain_selected,
				"listName":listName,
				"fileName":fileName,
			};
			
			jQuery.ajax({
				url: "{{url('/getFile')}}",
				method: "POST",
				data: data,
				success: function(response)
					{
						toastr.success(response.msg);
						$('#listTB').load(document.URL +  ' #listTB');
					},
					error: function(response)
					{
						toastr.warning(response.msg);

					}
				});
			}


			const isp_form_container = document.getElementById('isp_form_container');
			const geo_form_container = document.getElementById('geo_form_container');
			const list_form_container = document.getElementById('list_form_container');

		function showGeo() {
			if (document.getElementById('geo_form_container').style.display === "none") {
				document.getElementById('geo_form_container').style.display = "block";
			} else {
				document.getElementById('geo_form_container').style.display = "none";
			}
		};

		function showIsp() {
			if (document.getElementById('isp_form_container').style.display === "none") {
				document.getElementById('isp_form_container').style.display = "block";
			} else {
				document.getElementById('isp_form_container').style.display = "none";
			}
		};



		function addGeo(){
			geo_name = document.getElementById("geoName").value;
			geo_Code = document.getElementById("geoCode").value;
			// console.log(listName);
			// console.log(domain_selected);

			var data = {
				"_token": "{{ csrf_token() }}",
				"name": geo_name,
				"code":geo_Code,
			};
			

			
			jQuery.ajax({
				url: "{{url('/insertGeo')}}",
				method: "POST",
				data: data,
				success: function(response)
				{
					if(response.success){
						$('#list_form_container').load(document.URL +  ' #list_form_container');
						document.getElementById('geo_form_container').style.display = "none";
						toastr.success(response.msg);
					}else {
						toastr.warning(response.msg);
					}

				},
				error: function(response)
				{
					toastr.warning(response.msg);
				}
			});

			

		}

		function addIsp(){
			isp_name = document.getElementById("ispName").value;

			// console.log(listName);
			// console.log(domain_selected);

			
			var data = {
				"_token": "{{ csrf_token() }}",
				"name": isp_name,
			};
			
			
			jQuery.ajax({
				url: "{{url('/insertIsp')}}",
				method: "POST",
				data: data,
				success: function(response)
				{
					if(response.success){
						$('#list_form_container').load(document.URL +  ' #list_form_container');
						document.getElementById('isp_form_container').style.display = "none";
						toastr.success(response.msg);
					}else {
						toastr.warning(response.msg);
					}

				},
				error: function(response)
				{
					toastr.warning(response.msg);

				}
			});

			
		}

		function addList() {
			list_name = document.getElementById("list_name_form").value;
			isp_name = document.getElementById("isp_name_form").value;
			geo_name = document.getElementById("geo_name_form").value;
			mx = document.getElementById("mx_form").value;
			var data = {
				"_token": "{{ csrf_token() }}",
				"listName": list_name,
				"ispName": isp_name,
				"geoName": geo_name,
				"mx": mx,
			};
			
			jQuery.ajax({
				url: "{{url('/insert')}}",
				method: "POST",
				data: data,
				success: function(response)
				{
					
					if(response.success){
						console.log('iinside js');
						document.getElementById("list_name_form").value = "";
						document.getElementById("mx_form").value = "";
						$('#listTB').load(document.URL +  ' #listTB');
						document.getElementById('isp_form_container').style.display = "none";
						toastr.success(response.msg);
					}
					else {
						toastr.warning(response.msg);
					}

				},
				error: function(response)
				{
					toastr.error(response.msg);
				}
			});
		}

	</script>

</body>
</html>




