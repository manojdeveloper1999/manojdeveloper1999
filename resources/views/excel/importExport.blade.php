<html lang="en">
<head>
    <title>Order Data Export</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
</head>
<body>
    <div class="container" style="margin-top: 20px;">
        <div class="panel panel-default">
            <div class="panel-heading">
            <h4>Order Export</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('g-error'))
                            <div class="alert alert-danger">
                                <p>{{ Session::get('g-error') }}</p>
                                <p>Issue Order ID : {{ Session::get('error_order_id') }}</p>
                                
                            </div>
                        @endif                     
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        @if (Session::has('processed_count'))
                        <table class="table table-bordered status-table">
                            <thead>
                                <th>Processed Count</th>
                                <th>Success Count</th>
                                <th>Error Count</th>
                            </thead>
                            <tbody>
                                <td>{{ Session::get('processed_count') }}</td>
                                <td>{{ Session::get('success_count') }}</td>
                                <td>{{ Session::get('error_count') }}</td>
                            </tbody>
                        </table>
                                <p></p>
                        @endif 
                        <form style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ url('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="import_file" style="display: inline-block;" />
                            <button class="btn btn-primary">Import File</button><br>
                        </form>
                        @if ($max_id)
                            <span class="message"> * The order has been imported up to order No : <b><?php echo $max_id; ?></b></span>
                        @endif
                        <br>
                        <br>
                        @if($pending_order_count[0]->pending_order_count > 0)
                            <a href="{{ url('generate/product-url') }}"><button class="btn btn-primary">Generate Product URL</button></a>
                        @endif
                        <a href="{{ url('downloadExcel/csv') }}"><button class="btn btn-primary">Download CSV</button></a>
                        
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item disabled tot_info">Order's Product URL generation Count</li>
                            <li class="list-group-item">Total Order data Count <span class="badge label-primary"><?php echo $total_order_count[0]->total_order_count; ?></span></li>
                            <li class="list-group-item">Completed product URL Count <span class="badge label label-success"><?php echo $complete_order_count[0]->complete_order_count; ?></span></li>
                            <li class="list-group-item">Pending product URL Count <span class="badge label label-danger"><?php echo $pending_order_count[0]->pending_order_count; ?></span></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>