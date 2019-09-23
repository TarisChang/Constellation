@extends('layouts.app')
@section('css')
    <style>
        .all {
            font-size: 1.6rem;
            padding: 3rem;
            border-bottom: 1px solid lightgray;
        }

        .name {
            font-weight: bolder;
            color: #2a88bd;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">請選擇日期：
                        <select name="date" id="date" onchange="searchDate(this.value)">
                            @foreach($inputDates as $inputDate)
                                <option value="{{ $inputDate }}" {{ $date ==  $inputDate ? 'selected' : ''}}>{{ $inputDate }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if($dailyRecords->isNotEmpty())
                            @foreach($dailyRecords as $dailyRecord)
                                <div class="all">
                                    <div class="name">{{ $dailyRecord['name'] }}</div>
                                    <div>整體運勢評分：{{ $dailyRecord['total_n'] }}</div>
                                    <div>整體運勢說明：{{ $dailyRecord['total_d'] }}</div>
                                    <div>愛情運勢評分：{{ $dailyRecord['love_n'] }}</div>
                                    <div>愛情運勢說明：{{ $dailyRecord['love_d'] }}</div>
                                    <div>事業運勢評分：{{ $dailyRecord['work_n'] }}</div>
                                    <div>事業運勢說明：{{ $dailyRecord['work_d'] }}</div>
                                    <div>財運運勢評分：{{ $dailyRecord['money_n'] }}</div>
                                    <div>財運運勢說明：{{ $dailyRecord['money_d'] }}</div>
                                </div>
                            @endforeach
                        @else
                            無資料
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchDate(date) {
            console.log(date);
            const url = location.protocol + '//' + location.host + '/home?date=' + date;
            document.location.href = url;
        }
    </script>
@endsection
