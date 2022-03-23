@if(Auth::check())
<nav class="sidebar bg-dark toggled">
    <ul class="list-unstyled">
      @if(Auth::user()->hasRole('superadmin'))
        <li>
          <a href="#menuadmin" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-secret"></i> Admin</a>
          <ul class="collapse list-unstyled" id="menuadmin">
            <li class={!! (url('admin/user')==url()->current())?"active":"" !!}><a href="{!! url('admin/user') !!}" ><i class="fas fa-users"></i> List User</a></li>
            <li class={!! (url('admin/role')==url()->current())?"active":"" !!}><a href="{!! url('admin/role') !!}" ><i class="fas fa-user-circle"></i> Role User</a></li>
            <li class={!! (url('admin/permission')==url()->current())?"active":"" !!}><a href="{!! url('admin/permission') !!}" ><i class="fas fa-check-circle"></i> Permission Role</a></li>
            <li class={!! (url('admin/userlogs')==url()->current())?"active":"" !!}><a href="{!! url('admin/userlogs') !!}" ><i class="fa fa-history"></i> User Log</a></li>
          </ul>
        </li>
      @endif

      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_master'))
        <li>
          <a href="#master" data-toggle="collapse" aria-expanded="false"><i class="fab fa-bitbucket"></i> Master Data</a>
          <ul class="collapse list-unstyled" id="master">
            <li class={!! (url('pasien')==url()->current())?"active":"" !!}><a href="{!! url('pasien') !!}" ><i class="fa fa-address-book"></i> Data Pasien</a></li>
            {{-- <li class={!! (url('kamar')==url()->current())?"active":"" !!}><a href="{!! url('kamar') !!}" ><i class="fa fa-building"></i> Data Kamar</a></li>
            <li class={!! (url('nokamar')==url()->current())?"active":"" !!}><a href="{!! url('nokamar') !!}" ><i class="fas fa-list-ol"></i> Data No Kamar</a></li>
            <li class={!! (url('paket')==url()->current())?"active":"" !!}><a href="{!! url('paket') !!}" ><i class="fas fa-archive"></i> Data Paket</a></li>
            <li class={!! (url('#')==url()->current())?"active":"" !!}><a href="{!! url('#') !!}" ><i class="fas fa-archive"></i> Data User</a></li> --}}
          </ul>
        </li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_logbook'))
        <li>
          <a href="#logbook" data-toggle="collapse" aria-expanded="false"><i class="far fa-object-group"></i> Data Logbook</a>
          <ul class="collapse list-unstyled" id="logbook">
            <li class={!! (url('logbook')==url()->current())?"active":"" !!}><a href="{!! url('logbook') !!}" ><i class="fas fa-book"></i> Logbook Rawat Inap</a></li>
            <li class={!! (url('logbookrj')==url()->current())?"active":"" !!}><a href="{!! url('logbookrj') !!}" ><i class="fas fa-book"></i> Logbook Rawat Jalan</a></li>
          </ul>
        </li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_babyspa'))
        <li class={!! (url('babySPA')==url()->current())?"active":"" !!}><a href="{!! url('babySPA') !!}" ><i class="fa fa-history"></i> Reservasi Baby SPA</a></li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_kliniklaktasi'))
        <li class={!! (url('klinikLaktasi')==url()->current())?"active":"" !!}><a href="{!! url('klinikLaktasi') !!}" ><i class="fa fa-history"></i> Reservasi Klinik Laktasi</a></li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_radiologi'))
        <li class={!! (url('radiologi')==url()->current())?"active":"" !!}><a href="{!! url('radiologi') !!}" ><i class="fa fa-history"></i> Pendaftaran Tindakan Radiologi HSG & USG</a></li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_echocardiography'))
        <li class={!! (url('ecnocardiography')==url()->current())?"active":"" !!}><a href="{!! url('ecnocardiography') !!}" ><i class="fa fa-history"></i> Pendaftaran Echocardiography</a></li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_upadana'))
        <li class={!! (url('upadana')==url()->current())?"active":"" !!}><a href="{!! url('upadana') !!}" ><i class="fa fa-history"></i> Pendaftaran dr.Upadana</a></li>
      @endif
      @if(Auth::user()->hasRole('superadmin') OR Auth::user()->hasRole('menu_penomoran'))
        <li class={!! (url('nomorbpjs')==url()->current())?"active":"" !!}><a href="{!! url('nomorbpjs') !!}" ><i class="fa fa-history"></i> Penomoran BPJS</a></li>
      @endif
    </ul>
</nav>
@endif
