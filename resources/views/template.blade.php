<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>
      @php 
      $pageSegment = empty(Request::segment(1)) ? 'Dashboard' : Request::segment(1);
      @endphp
      {!!ucwords( str_replace("-"," ",$pageSegment) )!!} | Bank UMKM
    </title>
    {{-- favicon --}}
    <link href="{{ asset('img/icon.png') }}" rel="icon">
    <link href="{{ asset('img/icon.png') }}" rel="apple-touch-icon">
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/select2-develop/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css') }}" rel="stylesheet" />
    <link href="{{asset('vendor/sweetalert-master/dist/sweetalert.css')}}" rel="stylesheet" />

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <!-- firebase integration started -->

    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>

    <!-- Add additional services that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-functions.js"></script>

    <!-- firebase integration end -->

    <!-- Comment out (or don't include) services that you don't want to use -->
    <!-- <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-storage.js"></script> -->

    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-analytics.js"></script>
    <script src="{{ asset('js/firebase-messaging-sw.js') }}"></script>
  </head>

  <body id="page-top">
    <div class="loading">
      <div class="info">
        <img src="{{asset('img/loading.gif')}}" alt="">
        <p>Loading...</p>
      </div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <div class="left-sidebar">
        <ul
          class="navbar-nav sidebar sidebar-dark accordion"
          id="accordionSidebar"
        >
          <!-- Sidebar - Brand -->
          <a
            class="sidebar-brand d-flex align-items-center justify-content-center"
            href="{{ url('dashboard') }}"
          >
            <div class="sidebar-brand-icon">
              <i class="fas fa-running fa-fw"></i>
            </div>
            <div class="sidebar-brand-text"> Bank UMKM </div>
          </a>

          <!-- Nav Item - Dashboard -->
          <li class="nav-item {{Request::segment(1) == 'dashboard' ? 'active' : ''}}">
            <a class="nav-link" href="{{url('dashboard')}}">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span></a
            >
          </li>
          
          <li class="nav-item {{Request::segment(1) == 'user' ? 'active' : ''}}">
            <a class="nav-link" href="{{url('user')}}">
              <i class="fas fa-fw fa-user"></i>
              <span>User</span></a
            >
          </li>

          <li class="nav-item {{Request::segment(1) == 'master-scoring' ? 'active' : ''}}">
            <a
              class="nav-link collapsed"
              href="#"
              data-toggle="collapse"
              data-target="#master-scoring"
              aria-expanded="true"
              aria-controls="master-scoring"
            >
            <i class="fas fa-fw fa-list-ol "></i>
              <span>Master Scoring <i class="badge badge-success badge-notif"></i></span>
            </a>
            <div
              id="master-scoring"
              class="collapse"
              aria-labelledby="headingTwo"
              data-parent="#accordionSidebar"
            >
              <div class="py-2 collapse-inner rounded">
                <a class="nav-link" href="{{url('master-scoring/kategori-kriteria')}}">
                  <span>Kategori Kriteria</span>
                </a>
                <a class="nav-link" href="{{url('master-scoring/kriteria')}}">
                  <span>Kriteria</span>
                </a>
                <a class="nav-link" href="{{url('master-scoring/option')}}">
                  <span>Option</span>
                </a>
              </div>
            </div>
          </li>
          
          {{-- <li class="nav-item {{Request::segment(1) == 'tipe-nasabah' ? 'active' : ''}}">
            <a class="nav-link" href="{{url('tipe-nasabah')}}">
              <i class="fas fa-fw fa-layer-group"></i>
              <span>Tipe Nasabah</span></a
            >
          </li> --}}

          <li class="nav-item {{Request::segment(1) == 'nasabah' ? 'active' : ''}}">
            <a
              class="nav-link collapsed"
              href="#"
              data-toggle="collapse"
              data-target="#nasabah"
              aria-expanded="true"
              aria-controls="nasabah"
            >
            <i class="fas fa-fw fa-users "></i>
              <span>Nasabah <i class="badge badge-success badge-notif"></i></span>
            </a>
            <div
              id="nasabah"
              class="collapse"
              aria-labelledby="headingTwo"
              data-parent="#accordionSidebar"
            >
              <div class="py-2 collapse-inner rounded">
                <a class="nav-link" href="{{url('nasabah?verified=0')}}">
                  <span>Nasabah Belum Terverifikasi</span>
                </a>
                <a class="nav-link" href="{{url('nasabah?verified=1')}}">
                  <span>Nasabah Terverifikasi</span>
                </a>
                <a class="nav-link" href="{{url('data-tambahan-nasabah')}}">
                  <span>Pengajuan Data Tambahan Nasabah</span>
                </a>
                <a class="nav-link" href="{{url('syarat-pinjaman-umroh')}}">
                  <span>Pengajuan Syarat Pinjaman Umroh</span>
                </a>
              </div>
            </div>
          </li>
          
          <li class="nav-item {{Request::segment(1) == 'pinjaman' ? 'active' : ''}}">
            <a
              class="nav-link collapsed"
              href="#"
              data-toggle="collapse"
              data-target="#pinjaman"
              aria-expanded="true"
              aria-controls="pinjaman"
            >
            <i class="fas fa-fw fa-money-bill-wave "></i>
              <span>Pinjaman <i class="badge badge-success badge-notif"></i></span>
            </a>
            <div
              id="pinjaman"
              class="collapse"
              aria-labelledby="headingTwo"
              data-parent="#accordionSidebar"
            >
              <div class="py-2 collapse-inner rounded">
                <a class="nav-link" href="{{url('pinjaman?t=Pending')}}">
                  <span>Pengajuan Pinjaman</span>
                </a>
                <a class="nav-link" href="{{url('pinjaman?t=Terima')}}">
                  <span>Pinjaman Berjalan</span>
                </a>
                <a class="nav-link" href="{{url('pinjaman?t=Lunas')}}">
                  <span>Pinjaman Telah Lunas</span>
                </a>
                <a class="nav-link" href="{{url('pinjaman?t=Tolak')}}">
                  <span>Pinjaman Ditolak</span>
                </a>
              </div>
            </div>
          </li>

          <li class="nav-item {{Request::segment(1) == 'pelunasan' ? 'active' : ''}}">
            <a class="nav-link" href="{{url('pelunasan')}}">
              <i class="fas fa-fw fa-hand-holding-usd"></i>
              <span>Pelunasan</span></a
            >
          </li>
          
          <li class="nav-item {{Request::segment(1) == 'laporan' ? 'active' : ''}}">
            <a class="nav-link" href="{{url('laporan')}}">
              <i class="fas fa-fw fa-chart-line"></i>
              <span>Laporan Transaksi</span></a
            >
          </li>

          
          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
        </ul>
      </div>
      <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            {{-- <span class="my-auto">{{ Auth::user()->name }}</span> --}}
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-6000 small">{{auth()->user()->name}}</span>
                <i class="fa fa-user"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- <a class="dropdown-item" href="{{ route('user.ganti-password')}}">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ganti Password
                </a> --}}
                {{-- <div class="dropdown-divider"></div> --}}
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid common-container">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="h4 mb-0 solid-color font-weight-bold infopage">
                  <?php 
                    $pageSegment = !empty(Request::segment(1)) ? Request::segment(1) : '';
                  ?>
                  {{ ucwords( str_replace("-"," ",$pageSegment) ) }}
            </div>
            <div class="float-right info-text-page">
              <a href="#"> 
                {{ucwords( str_replace("-"," ",$pageSegment) )}}
              </a>
              @if (!empty($pageInfo))
                /
                <a href="#"> {{$pageInfo}}</a>
              @else
                <a href="#"></a>
              @endif
            </div>
          </div>
          <div class="row pb-5">
            <div class="col-md-12">
            @yield('container')
              </div>
          </div>
      </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright 2020 - <a href="https://limadigital.id" target="_blank">LIMA Digital</a></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/select2-develop/dist/js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') }}"></script> --}}
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{asset('vendor/sweetalert-master/dist/sweetalert-dev.js')}}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
/*       $(document).ready(function(){
        setInterval(function(){
          $.ajax({
            type : "get",
            url : "<?= url('pinjaman/cekNotif') ?>",
            success : function(data){
              if(data!=0){
                $(".badge-notif").html(data)
              }
            }
          })
        })
        }, 1000);
 */
      const tel = document.getElementById('kode_rekening');

      tel.addEventListener('input', function() {
        let start = this.selectionStart;
        let end = this.selectionEnd;
        
        const current = this.value
        const corrected = current.replace(/([^+0-9.]+)/gi, '');
        this.value = corrected;
        
        if (corrected.length < current.length) --end;
        this.setSelectionRange(start, end);
      });
    </script>
    <script type="text/javascript">
      // Your web app's Firebase configuration
      var firebaseConfig = {
        apiKey: "AIzaSyAuGdwqO6ViCzpWPQ6iBZbC_QYPtnCxT-8",
        authDomain: "bank-umkm.firebaseapp.com",
        projectId: "bank-umkm",
        storageBucket: "bank-umkm.appspot.com",
        messagingSenderId: "672502479871",
        appId: "1:672502479871:web:3511ecbd0036e8c77ec5ca",
        measurementId: "G-MD213BVWLM"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      // firebase.analytics();
      const messaging = firebase.messaging();
        messaging
      .requestPermission()
      .then(function () {
      //MsgElem.innerHTML = "Notification permission granted." 
        console.log("Notification permission granted.");

          // get the token in the form of promise
        return messaging.getToken()
      })
      .then(function(token) {
      // print the token on the HTML page     
        console.log(token);
      })
      .catch(function (err) {
        console.log("Unable to get permission to notify.", err);
      });

      messaging.onMessage(function(payload) {
          console.log(payload);
          var notify;
          notify = new Notification(payload.notification.title,{
              body: payload.notification.body,
              icon: payload.notification.icon,
              tag: "Dummy"
          });
          console.log(payload.notification);
      });

          //firebase.initializeApp(config);
      var database = firebase.database().ref().child("/users/");
        
      database.on('value', function(snapshot) {
          renderUI(snapshot.val());
      });

      // On child added to db
      database.on('child_added', function(data) {
        console.log("Comming");
          if(Notification.permission!=='default'){
              var notify;
              
              notify= new Notification('CodeWife - '+data.val().username,{
                  'body': data.val().message,
                  'icon': 'bell.png',
                  'tag': data.getKey()
              });
              notify.onclick = function(){
                  alert(this.tag);
              }
          }else{
              alert('Please allow the notification first');
          }
      });

      self.addEventListener('notificationclick', function(event) {       
          event.notification.close();
      });
    </script>
  </body>
</html>
