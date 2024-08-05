        <h2 class="h5 no-margin-bottom" style="margin-top: 10px">Dashboard</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-4 col-sm-6">
                      <div class="statistic-block block">
                          <div class="progress-details d-flex align-items-end justify-content-between">
                              <div class="title">
                                  <div class="icon"><i class="icon-user-1"></i></div><strong>Orang Tersedia</strong>
                              </div>
                              <div class="number dashtext-1">{{ $orangTersedia }}</div>
                          </div>
                          <div class="progress progress-template">
                              <div role="progressbar" style="width: {{ ($orangTersedia / $totalUsers) * 100 }}%" aria-valuenow="{{ ($orangTersedia / $totalUsers) * 100 }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="statistic-block block">
                          <div class="progress-details d-flex align-items-end justify-content-between">
                              <div class="title">
                                  <div class="icon"><i class="icon-user-1"></i></div><strong>Orang Bekerja</strong>
                              </div>
                              <div class="number dashtext-3">{{ $orangBekerja }}</div>
                          </div>
                          <div class="progress progress-template">
                              <div role="progressbar" style="width: {{ ($orangBekerja / $totalUsers) * 100 }}%" aria-valuenow="{{ ($orangBekerja / $totalUsers) * 100 }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                      <div class="statistic-block block">
                          <div class="progress-details d-flex align-items-end justify-content-between">
                              <div class="title">
                                  <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Pekerjaan Bulan Ini</strong>
                              </div>
                              <div class="number dashtext-4">{{ $totalPekerjaanBulanIni }}</div>
                          </div>
                          <div class="progress progress-template">
                            <div role="progressbar" style="width: {{ $persentasePekerjaanBulanIni }}%" aria-valuenow="{{ $persentasePekerjaanBulanIni }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
      <section class="no-padding-bottom">
        <div class="row">
            <div class="col-lg-6">
                <div class="messages-block block" style="max-height: 300px; overflow-y: auto;">
                    <div class="title"><strong>Pekerjaan Hari Ini</strong></div>
                    <div class="messages">
                        @foreach ($pekerjaanHariIni as $index => $pekerjaan)
                            @if ($index < 5)
                                <a class="message d-flex align-items-center">
                                    <div class="content">
                                        <strong class="d-block">{{ $pekerjaan->keterangan }}</strong>
                                        <span class="d-block">{{ $pekerjaan->uraian_kegiatan }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>            
            </div>
            <div class="col-lg-6">
                <div class="messages-block block" style="max-height: 300px; overflow-y: auto;">
                    <div class="title"><strong>Kontribusi Bulan Ini</strong></div>
                    <div class="messages">
                        @foreach ($kontribusiBulanIni as $index => $contribution)
                            @if ($index < 5)
                                <a class="message d-flex align-items-center">
                                    <div class="content">
                                        <strong class="d-block">{{ $contribution['name'] }}</strong>
                                        <span class="d-block">Total Kontribusi: {{ $contribution['total'] }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
               {{-- <p class="no-margin-bottom">2018 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p> --}}
            </div>
          </div>
        </footer>