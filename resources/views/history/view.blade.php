@extends('layouts.master')
@section('title','Riwayat Kunjungan')
@section('css')
 <style>
    /* Tab Navigation */
    .tab-nav {
      display: flex;
      justify-content: center;
      background: #1890ff;
    }

    .tab-btn {
        flex: 1;
        padding: 8px 10px; /* Lebih kompak */
        font-size: 13px;
        font-weight: 600;
    }

    .tab-content {
        display: none;
        padding: 15px;
        background: white;
        min-height: auto; /* Atau cukup dihapus */
    }


    .tab-btn:hover,
    .tab-btn.active {
      background: #1477cc;
    }

    /* Tab Content */
    .tab-content {
      display: none;
      padding: 20px;
      background: white;
     
    }

    .tab-content.active {
      display: block;
    }

    .section-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
      color: black;
    }

    /* Bar Chart */
    .bar-chart {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .bar {
      display: flex;
      align-items: center;
    }

    .bar-label {
      width: 160px;
      font-size: 14px;
    }

    .bar-value {
      height: 20px;
      background: #ff4d4d;
      border-radius: 4px;
      text-align: right;
      color: #fff;
      padding: 0 8px;
      font-size: 12px;
    }

    /* Timeline */
    .timeline {
      position: relative;
      padding-left: 25px;
      margin-top: 10px;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 10px;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #1890ff;
    }

    .timeline-item {
      position: relative;
      margin-bottom: 20px;
      padding-left: 15px;
    }

    .timeline-item::before {
      content: '';
      position: absolute;
      left: -7px;
      top: 6px;
      width: 14px;
      height: 14px;
      background: #1890ff;
      border: 2px solid white;
      border-radius: 50%;
    }

    .timeline-date {
      font-weight: bold;
      margin-bottom: 5px;
      color: black;
    }

    .timeline-desc {
      font-size: 14px;
    }
    b{
      color: black;
    }
    .tab-content{
      padding:1 !important;
    }
</style>   
@endsection
@section('content')
    <div class="py-5" style="padding-top:4rem !important;">
        <div class="container" style="max-width: 1000px;">
          <div class="card mb-3 w-100">
              
                  
                      <div class="contact-form">
                        <div class="col-md-12 mb-4">
                                
                                
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size:15px">{{ $produk->judul }}</h5>
                                    <div class="tab-nav" style="font-size:15px">
                                        <button class="tab-btn active" onclick="showTab('komplain')">Komplain</button>
                                        <button class="tab-btn" onclick="showTab('kunjungan')">Kunjungan</button>
                                    </div>
                                    <!-- KOMPLAIN TAB -->
                                    <div class="tab-content active" id="komplain">
                                        <div class="section-title" style="font-size:13px">Riyawat Komplain</div>
                                        <hr style="border:1px solid black;">
                                        <div class="timeline">
                                          @foreach ($komplain as $item)
                                              <div class="timeline-item">
                                                <div class="timeline-date">{{ TanggalHelper::get_date_time($item['created_at']) }}</div>
                                                <div class="timeline-desc">
                                                  {{ $item['pesan'] }}
                                                </div>
                                                <div class="timeline-desc">
                                                  @if ($item->tgl_kunjungan)
                                                      <b>Tgl. Kunjungan : {{ TanggalHelper::get_dd_mm_yyyy($item['tgl_kunjungan']) }}</b>
                                                      
                                                  @endif
                                                  
                                                </div>
                                                <div class="timeline-desc">
                                                  @if ($item->jadwalTeknisi->isNotEmpty())
                                                    <b>
                                                     
                                                      @foreach ($item->jadwalTeknisi as $teknisi)
                                                         {{ $teknisi->user->nama_lengkap }}@if (!$loop->last), @endif
                                                      @endforeach
                                                    </b>
                                                  @endif
                                                  
                                                  
                                                </div>
                                                @if ($item['sts'])
                                                  <small><i style="color:green;" class="fa fa-check">Komplain Telah Selesai</i></small>
                                                @endif
                                                
                                              </div>
                                          @endforeach
                                          
                                          
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <!-- KUNJUNGAN TAB -->
                                        <div class="tab-content" id="kunjungan">
                                            <div class="section-title" style="font-size:13px">Riwayat Kunjungan</div>
                                            <hr style="border:1px solid black;">
                                            @foreach ($result as $rutin)
                                              <font style="color: black;">{{ $rutin['catatan'] }}</font>
                                              <div class="timeline">
                                                  @foreach ($rutin['tanggal'] as $tanggalItem)
                                                    <div class="timeline-item">
                                                        <div class="timeline-date">{{ TanggalHelper::get_dd_mm_yyyy($tanggalItem['tanggal']) }}</div>
                                                        @if ($tanggalItem['teknisi']->count())
                                                          @foreach ($tanggalItem['teknisi'] as $tek)
                                                            <div class="timeline-desc">
                                                              
                                                              {{ $tek->user->nama_lengkap.' :'.$tek->catatan }}@if (!$loop->last)<br/> @endif
                                                              
                                                            </div>
                                                          @endforeach
                                                        @endif
                                                    </div>
                                                  @endforeach
                                              </div>
                                            @endforeach
                                        </div>
                                    
                                    
                                </div>
                            
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
@section('js')
<script>
    function showTab(id) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
      document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      event.target.classList.add('active');
    }
</script>
@endsection
@endsection