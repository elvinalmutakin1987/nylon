@php
    use App\Models\Ordercatatan;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;

    $ordercatatan = Ordercatatan::where('order_id', $order_id)->orderBy('created_at', 'desc')->get();
    $catatandate = Ordercatatan::select(DB::raw('date(created_at) as created_at'))
        ->where('order_id', $order_id)
        ->groupBy('created_at')
        ->get();
@endphp
<!-- Timelime example  -->
<div class="row">
    <div class="col-md-12">
        @foreach ($ordercatatan as $d3)
            @php
                $user = User::find($d3->created_by);
            @endphp
            <!-- The time line -->
            <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($d3->created_at)->diffForHumans() }}</span>
                <h6 class="timeline-header no-border"><a href="#">
                        {{ $user->name }}
                    </a> {{ $d3->catatan }}
                </h6>
            </div>
            <!-- END timeline item -->
        @endforeach
    </div>
    <!-- /.col -->
</div>
<!-- /.timeline -->
