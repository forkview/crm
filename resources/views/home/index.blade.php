@extends('layouts.main')
@section('content')


{{--Header page --}}
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Forms</h1>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Form Elements
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="start_stop">
                                <div class="panel-body">
                                    <?php if($status == 0): ?>
                                    <button id="start" class="button"> Start work </button>
                                    <?php elseif($status == 1): ?>
                                    <button id="stop" class="button"> Stop work </button>
                                    <?php elseif($status == 2): ?>
                                    <button id="done" class="button"> Work Done</button>
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

<script>
    var $status_work = <?php echo $status ?>;

    $("#start_stop").on('click', '#start',function () {
            $.ajax({
                type: "POST",
                url: '{{ url('startWork') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    server = response;
                    $("#start").text('Stop work');
                    $("#start").attr('id', 'stop');
                }
            });
        });
    $("#start_stop").on('click', '#stop',function () {
        $.ajax({
            type: "POST",
            url: '{{ url('stopWork') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                server = response;
                $("#stop").text('Done Work');
                $("#stop").attr('id', 'done');
            }
        });
    });

</script>
@endsection
