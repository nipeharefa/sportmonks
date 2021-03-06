@extends("layouts.default")

@section("meta")
    <meta http-equiv="refresh" content="60">
@endsection

@section("content")
    <div class = "container">
        <h1>@lang("application.Livescores") - {{date($date_format)}} </h1>
        <p>@lang("application.Last update"): {{date($date_format . " H:i:s")}} </p>

        @if(isset($livescores))
            @if(count($livescores) >= 1)
                @if(count($livescores) >= 100)
                    <p style="color:red">@lang("application.msg_too_much_results", ["count" => count($livescores)])</p>
                @endif
                @php $last_league_id = 0; @endphp
                @foreach($livescores as $livescore)
                    @if(in_array($livescore->time->status, array("NS", "FT", "FT_PEN", "AET", "CANCL", "POSTP", "INT", "ABAN", "SUSP", "AWARDED", "DELAYED", "TBA", "WO", "AU")))
                        @continue
                    @endif
                    @php
                        $league = $livescore->league->data;
                        $homeTeam = $livescore->localTeam->data;
                        $awayTeam = $livescore->visitorTeam->data;
                    @endphp
                    @if($livescore->league_id == $last_league_id)
                        <tr>
                            <td scope="row">{{$homeTeam->name}}</td>
                            <td scope="row">{{$awayTeam->name}}</td>
                            <td scope="row">{{$livescore->scores->localteam_score}} - {{$livescore->scores->visitorteam_score}}</td>

                            @if(in_array($livescore->time->status, array("LIVE", "HT", "ET", "PEN_LIVE", "AET", "BREAK")))
                                @if($livescore->time->status == "HT")
                                    <td scope="row">HT</td>
                                @elseif(in_array($livescore->time->minute, array(0, null)) && $livescore->time->added_time == 0)
                                    <td scope="row">0&apos;</td>
                                @elseif(in_array($livescore->time->added_time, array(0, null)))
                                    <td scope="row">{{$livescore->time->minute}}&apos;</td>
                                @elseif(!in_array($livescore->time->added_time, array(0, null)))
                                    <td scope="row">{{$livescore->time->minute}}&apos;+{{$livescore->time->added_time}}</td>
                                @else
                                    <td scope="row">{{$livescore->time->minute}}</td>
                                @endif
                            @else
                                <td scope="row">{{date($date_format . " H:i", strtotime($livescore->time->starting_at->date_time))}}</td>
                            @endif
                            <td scope="row"><a href="{{route("fixturesDetails", ["id" => $livescore->id])}}"><i class="fa fa-info-circle"></i></a></td>
                        </tr>
                    @else
                        <table class="table table-striped table-light table-sm" width="100%">
                            <caption><a href="{{route("leaguesDetails", ["id" => $league->id])}}" style="font-weight: bold">{{$league->name}}</a></caption>
                            <thead>
                                <tr>
                                    <th scope="col" width="35%"></th>
                                    <th scope="col" width="35%"></th>
                                    <th scope="col" width="10%"></th>
                                    <th scope="col" width="17%"></th>
                                    <th scope="col" width="3%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td scope="row">{{$homeTeam->name}}</td>
                                <td scope="row">{{$awayTeam->name}}</td>
                                <td scope="row">{{$livescore->scores->localteam_score}} - {{$livescore->scores->visitorteam_score}}</td>

                                @if(in_array($livescore->time->status, array("LIVE", "HT", "ET", "PEN_LIVE", "AET", "BREAK")))
                                    @if($livescore->time->status == "HT")
                                        <td scope="row">HT</td>
                                    @elseif(in_array($livescore->time->minute, array(0, null)) && $livescore->time->added_time == 0)
                                        <td scope="row">0&apos;</td>
                                    @elseif(in_array($livescore->time->added_time, array(0, null)))
                                        <td scope="row">{{$livescore->time->minute}}&apos;</td>
                                    @elseif(!in_array($livescore->time->added_time, array(0, null)))
                                        <td scope="row">{{$livescore->time->minute}}&apos;+{{$livescore->time->added_time}}</td>
                                    @else
                                        <td scope="row">{{$livescore->time->minute}}</td>
                                    @endif
                                @else
                                    <td scope="row">{{date($date_format . " H:i", strtotime($livescore->time->starting_at->date_time))}}</td>
                                @endif
                                <td scope="row"><a href="{{route("fixturesDetails", ["id" => $livescore->id])}}"><i class="fa fa-info-circle"></i></a></td>
                            </tr>
                    @endif
                    @php $last_league_id = $livescore->league_id; @endphp
                @endforeach
                </tbody>
            </table>
            @else
                <p>@lang("application.msg_no_livescores_now")</p>
            @endif
        @endif
    </div>
@endsection