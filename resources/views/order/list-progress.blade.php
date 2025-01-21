@php

    use App\Models\Orderdetail;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;

    $orderdetail = Orderdetail::where('order_id', $order->id)
        ->orderBy('created_at', 'desc')
        ->get();
    $catatandate = Orderdetail::select(DB::raw('date(created_at) as created_at'))
        ->where('order_id', $order->id)
        ->groupBy('created_at')
        ->get();
@endphp
<!-- Timelime example  -->
<div class="row">
    <div class="col-md-12">
        <div class="timeline">
            @foreach ($orderdetail as $d)
                @php
                    $user = User::find($d->created_by);
                @endphp
                <!-- The time line -->
                <div>
                    <i class="fas fa-user bg-gray"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i>
                            {{ \Carbon\Carbon::parse($d->created_at)->diffForHumans() }}</span>
                        <h3 class="timeline-header no-border"><a href="#">
                                {{ $user->name }}
                            </a> {{ $d->catatan }}
                        </h3>
                    </div>
                </div>
                <!-- END timeline item -->
            @endforeach
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.timeline -->
