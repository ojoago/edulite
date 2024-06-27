 @foreach($psycho as $row)
                @if($row->baseKey->isNotEmpty())
                    <table class="psychoTable">
                        <thead>
                            <tr>
                                <th>{{$row->psychomotor}}</th>
                                @for ($i = $row->max; $i > 0; $i--)
                                    <th>{{$i}}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->baseKey as $rw)
                            @php
                                $score = getPsychoKeyScore(student:$result->student_pid,param:$param,key:$rw->pid);
                            @endphp
                            <tr>
                                <td> {{$rw->title}} </td>
                                @for ($i = $row->max; $i > 0; $i--)
                                    @if($i == $score)
                                    <td> <i class="bi bi-check"></i></td>
                                    @else
                                    <td></td>
                                    @endif
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach