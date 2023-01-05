@extends('admin.sidebar.sidebar')

@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-5">
            <h1>Api Logs</h1>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div id="example2_wrapper" class="dataTables_wrapper table-responsive dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12">
                          <table id="example2" class="table overflow-auto table-bordered table-hover dataTable dtr-inline"  id="table" role="grid">
                      <thead>
                        <th>Date-Time</th>
                        <th>Request Method</th>
                        <th>Request URL</th>
                        <th>Request Body</th>
                        <th>Response Status</th>
                        <th>Response Body</th>
                      </thead>
                      <tbody>

                      @if ($data == NULL)
                        <tr>
                          <td colspan="6" class="text-center">No Data Found</td>
                        </tr>
                      @else

                      @foreach ( $data as $row )
                            @php
                                //  dd($row);
                            @endphp
                            <tr class="odd">
                            <td>{{ $row['date_time'] }}</td>
                            <td>{{ $row['request']['method'] }}</td>
                            <td>{{ $row['request']['url'] }}</td>
                            <td>{{ $row['request']['body'] }}</td>
                            <td>{{ $row['response']['status'] }}</td>
                            <td >{{ $row['response']['body'] }}</td>
                          </tr>
                        @endforeach
                      </tbody>
            
                    </table></div></div>{{ $data->links() }}
                      @endif
                        
                      
                    
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      </div><!-- /.container-fluid -->
    </section>
    @endsection

