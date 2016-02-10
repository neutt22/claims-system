<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

	google.load('visualization', '1.0', {'packages':['corechart']});
	google.setOnLoadCallback(drawChart);

	function drawChart(){

		// DM stats
		var data_dm = new google.visualization.DataTable();
		data_dm.addColumn('string', 'DM');
		data_dm.addColumn('number', 'Count');
		data_dm.addRows([
			['Incomplete DM', {{ $chart_inc['dm'] }}],
			['Complete DM', {{ $chart_complete['dm'] }}],
		]);

		var options_dm = {
			'title':'DM Statistics',
			'width':350,
			'height':250,
			'height': 150,
			'is3D':true,
			'chartArea':{left:0, top:'15%'},
		};

		// Policy stats
		var data_policy = new google.visualization.DataTable();
		data_policy.addColumn('string', 'Policy');
		data_policy.addColumn('number', 'Count');
		data_policy.addRows([
			['Incomplete Policy', {{ $chart_inc['policy'] }}],
			['Complete Policy', {{ $chart_complete['policy'] }}],
		]);

		var options_policy = {
			'title':'Policy Statistics',
			'width':350,
			'height':250,
			'height': 150,
			'is3D':true,
			'chartArea':{left:0, top:'15%'},
		};

		// Stage stats
		var data_stage = new google.visualization.DataTable();
		data_stage.addColumn('string', 'Stage');
		data_stage.addColumn('number', 'Count');
		data_stage.addRows([
			['Stage 1', {{ $stages['stage_1'] }}],
			['Stage 2', {{ $stages['stage_2'] }}],
			['Stage 3', {{ $stages['stage_3'] }}],
			['Stage 4', {{ $stages['stage_4'] }}],
		]);

		var options_stage = {
			'title':'Stages Statistics',
			'width':350,
			'height':250,
			'height': 150,
			'is3D':true,
			'chartArea':{left:0, top:'15%'},
		};

		// Documents stats
		var data_documents = new google.visualization.DataTable();
		data_documents.addColumn('string', 'Documents');
		data_documents.addColumn('number', 'Count');
		data_documents.addRows([
			['Incomplete', {{ $chart_inc['documents'] }}],
			['Complete', {{ $chart_complete['documents'] }}],
		]);

		var options_documents = {
			'title':'Documents Statistics',
			'width':350,
			'height':250,
			'height': 150,
			'is3D':true,
			'chartArea':{left:0, top:'15%'},
		};

		// Status stats
		var data_status = new google.visualization.DataTable();
		data_status.addColumn('string', 'Status');
		data_status.addColumn('number', 'Count');
		data_status.addRows([
			['Denied', {{ $stats['denied'] }}],
			['Approved', {{ $stats['approved'] }}],
			['Closed', {{ $stats['closed'] }}],
			['Pending', {{ $stats['pending'] }}],
		]);

		var options_status = {
			'title':'Claims Statistics',
			'width':350,
			'height':250,
			'height': 150,
			'is3D':true,
			'chartArea':{left:0, top:'15%'},
		};

		// Encoded status
		var data_encoded = google.visualization.arrayToDataTable([
	        ['Filed Claims', 'Filed Claims',],
	        ['January', {{ $months['jan'] }}],
	        ['February', {{ $months['feb'] }}],
	        ['March', {{ $months['mar'] }}],
	        ['April', {{ $months['apr'] }}],
	        ['May', {{ $months['may'] }}],
	        ['June', {{ $months['jun'] }}],
	        ['July', {{ $months['jul'] }}],
	        ['August', {{ $months['aug'] }}],
	        ['September', {{ $months['sep'] }}],
	        ['October', {{ $months['oct'] }}],
	        ['November', {{ $months['nov'] }}],
	        ['December', {{ $months['dec'] }}],
      	]);

      	var options_encoded = {
	        title: 'Claim Spikes 2016',
	        chartArea: {width: '50%'},
	        hAxis: {
	          title: 'Filed Claims',
	          minValue: 0
	        },
	        vAxis: {
	          title: 'Month'
	        }
      	};

		var chart_dm = new google.visualization.PieChart(document.getElementById('chart_dm'));
		chart_dm.draw(data_dm, options_dm);

		var chart_policy = new google.visualization.PieChart(document.getElementById('chart_policy'));
		chart_policy.draw(data_policy, options_policy);

		var chart_stage = new google.visualization.PieChart(document.getElementById('chart_stage'));
		chart_stage.draw(data_stage, options_stage);

		var chart_documents = new google.visualization.PieChart(document.getElementById('chart_documents'));
		chart_documents.draw(data_documents, options_documents);

		var chart_status = new google.visualization.PieChart(document.getElementById('chart_status'));
		chart_status.draw(data_status, options_status);

		var chart_encoded = new google.visualization.BarChart(document.getElementById('chart_encoded'));
		chart_encoded.draw(data_encoded, options_encoded);
	}
</script>