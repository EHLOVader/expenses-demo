@extends('app')

@section('content')

    <h1>Edit an expense note</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {!! Form::model($expense, array('route' => ['expenses.update', $expense->id], 'class' => 'form-horizontal')) !!}

    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
        {!! Form::label('base_amount', 'Base Amount', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('base_amount', null, array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
        </div>
    </div>


    <h3>Supplements <a class='btn btn-xs btn-default' href="#" id="add_supplement">Add one</a></h3>

    @if(count($expense['supplements'])<1)
        No supplements (yet)
    @endif

    <div id="supplements">
    @foreach($expense['supplements'] as $supplement)

        {!! Form::setModel($supplement) !!}

        <div class="form-group">
            {!! Form::label('name', 'Supplement name', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('name', null, array('class' => 'form-control', 'name' => 'name['.$supplement->id.']' )) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('amount', 'Amount', ['class' => 'col-sm-2 control-label']) !!}
             <div class="col-sm-10">
                 {!! Form::text('amount', null, array('class' => 'form-control', 'name' => 'amount['.$supplement->id.']')) !!}
             </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <?php $value = ($supplement['commissionable']=='1') ? 'checked' : ''; ?>
                        <input type="checkbox" name="commissionable[{{ $supplement->id }}]" {{ $value }}> Commissionable ?
                    </label>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    <hr>

    {!! Form::submit('Update expense', array('class' => 'btn btn-primary')) !!}

    {!! Form::close() !!}

    @include('expenses.supplement_template')

@endsection

@section('bottomscripts')
    <script>
        $(document).ready(function() {
            // functionality for the 'Add one' button
            var template = $('#hidden-template').html();
            $('#add_supplement').click(function() {
                $('#supplements').append(template);
            });

            // fancy auto-closing alert
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 1200);
        });
    </script>
@endsection