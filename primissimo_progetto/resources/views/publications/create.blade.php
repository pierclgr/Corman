@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="content">
	                    <form action="{{ action('PublicationController@store') }}" method="POST" enctype="multipart/form-data">
	                    	{{csrf_field()}}
	                        <input name="_method" type="hidden" value="POST">
		                    <table class="table table-condensed">
							    <thead>
							     	<tr>
							       		<th>Field</th>
							        	<th>Fill in the field</th>
							      	</tr>
							    </thead>
							    <tbody>
							     	<tr>
							        	<td>Paper title (*)</td>
							        	<td><input class="form-control" id="titolo" name="titolo" type="text" placeholder="Enter a title (max 255 chars)" required></td>
							      	</tr>
							      	<tr>
							        	<td>Paper type (*)</td>
							        	<td><input class="form-control" id="tipo" name="tipo" type="text" placeholder="Enter the type of the paper (venue, scientific, ecc)" required /></td>
							      	</tr>
                      <tr>
							        	<td>Paper PDF</td>
							        	<td><input type="file" class="form-control-file space" name="pdf"></td>
							      	</tr>
							      	<tr>
							      		<td>Paper visibility (*)</td>
							      		<td>
							      			<div class="button-group">
								      			<div class="radio">
												  	<label><input type="radio" name="visibilita" value="1" checked="checked">Public</label>
												</div>
												<div class="radio">
												  	<label><input type="radio" name="visibilita" value="0">Private</label>
												</div>
											</div>
										</td>
							      	</tr>	
							      	<tr>
							        	<td>Paper tags (*)</td>
							        	<td><input class="form-control" id="tags" name="tags" type="text" placeholder="Enter a list of tags separated by a ',' (max 255 chars)"></td>
							      	</tr>
							      	<tr>
							        	<td>List of coauthors(*)</td>
							        	<td><input class="form-control" id="coautori" name="coautori" type="text" placeholder="Enter a list of coauthors separated by a ',' (max 255 chars)"></td>
							      	</tr>

							    </tbody>
							</table>
							<h6>Fields with (*) must be set.</h6>
							<button class="btn btn-success " name="submit" type="submit">Create</button>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection