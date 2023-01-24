<?php

$args = array(
    'role'    => 'um_anak',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users( $args );

$nama =  '<option value="">pilih nama</option>';
foreach ( $users as $user ) {
  $meta = get_user_meta($user->ID);
  $tanggal_lahir = $meta['birth_date'][0];
  //print_r($meta);
    $nama .= '<option value="'.$user->ID.'">' . esc_html( $user->display_name ) .' '.$tanggal_lahir.'</option>';
}

$bln = array(
  "Januari",
  "Februari",
  "Maret",
  "April",
  "Mei",
  "Juni",
  "July",
  "Agustus",
  "September",
  "Oktober",
  "November",
  "Desember"
);
$bulan_opsi = '';
$bulan_ini = date("m");
$tahun_ini = date("Y");
for($bulan=1; $bulan<=12; $bulan++){
  $selected = '';
  if($bulan == $bulan_ini){
    $selected = "selected";
  }
  $bulan_opsi .= "<option $selected value='$bulan'>".$bln[$bulan-1]."</option>"; 
}
?>
<h1 class="text-center">Cek Data Gizi</h1>
<table class="table table-bordered" style="max-width: 500px">
    <thead>
      <tr>
        <th>Umur</th>
        <th>Tinggi</th>
        <th>Berat</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>0-6 bulan</td>
        <td>49,9 - 67,6 Cm</td>
        <td>3,3 - 7,9 Kg</td>
      </tr>
      <tr>
        <td>7-11 Bulan</td>
        <td>69,2-74,5 Cm</td>
        <td>8,3-9,4 Kg</td>
      </tr>
      <tr>
        <td>1-3 Tahun</td>
        <td>75,7-96,1 Cm</td>
        <td>9,9-14,3 Kg</td>
      </tr>
      <tr>
        <td>4-6 Tahun</td>
        <td>96,7-112 Cm</td>
        <td>14,5-19 Kg</td>
      </tr>
      <tr>
        <td>7-12 Tahun</td>
        <td>130-145 Cm</td>
        <td>27-36 Kg</td>
      </tr>
      <tr>
        <td>13-18 Tahun</td>
        <td>158-165 Cm</td>
        <td>46-50 Kg</td>
      </tr>
    </tbody>
</table>
<form style="width: 500px; margin: auto;" class="text-center">
  <div class="form-group">
    <label for="">Masukan Data</label>
    <div class="mb-2">
      <label class="form-label">Pilih Nama Anak</label>
      <select class="form-control" name="nama-anak">
        <?php echo $nama; ?>
      </select>
    </div>
    <div class="mb-2">
      <label class="form-label">Tahun Pemeriksaan</label>
      <input type="number" class="form-control" name="tahun_pemeriksaan" value="<?php echo $tahun_ini; ?>">
    </div>    
    <div class="mb-2">
      <label class="form-label">Bulan Pemeriksaan</label>
      <select class="form-control" name="bulan_pemeriksaan">
        <?php echo $bulan_opsi; ?>
      </select>
    </div>   
    <div class="mb-2">
      <label class="form-label">Tanggal Lahir</label>
      <input type="date" class="form-control" name="tanggal-lahir">
    </div>
    <div class="mb-2">
      <label class="form-label">Berat Badan</label>
      <input type="number" class="form-control" name="berat-badan">
    </div>
    <div class="mb-2">
      <label class="form-label">Tinggi Badan</label>
      <input type="text" class="form-control" name="tinggi-badan">
    </div>
    <button type="button" class="btn btn-primary" id="simpan">Proses</button>    
  </div>
</form>

  <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Status Gizi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>

  function _calculateAge(date) { // birthday is a date
      var birthday = new Date(date);
      var ageDifMs = Date.now() - birthday.getTime();
      var ageDate = new Date(ageDifMs); // miliseconds from epoch
      var bulan = (ageDate.getMonth()+1)/12;
      ageDate = ageDate.getUTCFullYear() - 1970;
      return Math.abs(ageDate)+bulan;
  }
  jQuery(document).ready(function(){
    jQuery("#simpan").on("click", function(e){
      e.preventDefault();
      var umur = jQuery("input[name='tanggal-lahir']").val();
      if(umur == ''){
        return alert("Tanggal lahir tidak boleh kosong!");
      }
      var berat = +jQuery("input[name='berat-badan']").val();
      var tinggi = +jQuery("input[name='tinggi-badan']").val();
      umur = _calculateAge(umur);
      var ket_umur = '';
      var ket_berat = '';
      var ket_tinggi = '';

      if(
        umur >= 0
        && umur <= 0.5
      ){
        ket_umur = 'umur dibawah 6 bulan';
        if(
          berat>=3.3
          && berat<=7.9
        ){
          ket_berat ='berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=49.9
          && tinggi<=67.6
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }else if(
        umur >= 0.5
        && umur < 1
      ){
        ket_umur = 'umur 7-11 Bulan';
        if(
          berat>=8.3
          && berat<=9.4
        ){
          ket_berat = 'berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=69.2
          && tinggi<=74.5
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }else if(
        umur >= 1.1
        && umur <= 3.9
      ){
        ket_umur = 'umur 1-3 Tahun';
        if(
          berat>=9.9
          && berat<=14.3
        ){
          ket_berat = 'berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=75.7
          && tinggi<=96.1
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }else if(
        umur >= 3.9
        && umur <= 6.9
      ){
        ket_umur = 'umur 4-6 tahun';
        if(
          berat>=14.5
          && berat<=19
        ){
          ket_berat ='berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=96.7
          && tinggi<=112
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }else if(
        umur >= 6.9
        && umur <= 12.9
      ){
        ket_umur = 'umur 7-12 Tahun';
        if(
          berat>=27
          && berat<=36
        ){
          ket_berat ='berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=130
          && tinggi<=145
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }else if(
        umur >= 12.9
        && umur <= 18
      ){
        ket_umur = 'umur 13-18 Tahun';
        if(
          berat>=46
          && berat<=50
        ){
          ket_berat ='berat '+berat+' ideal.';
        }else{
          ket_berat = 'berat '+berat+' tidak ideal.';
        }
        if(
          tinggi>=158
          && tinggi<=165
        ){
          ket_tinggi = 'tinggi '+tinggi+' ideal';
        }else{
          ket_tinggi = 'tinggi '+tinggi+' tidak ideal';
        }
      }
      var table = ''
        +'<table>'
          +'<thead>'
            +'<tr>'
              +'<th>Umur</th>'
              +'<th>Tinggi</th>'
              +'<th>Keterangan Tinggi</th>'
              +'<th>Berat</th>'
              +'<th>Keterangan Berat</th>'
            +'</tr>'
          +'</thead>'
          +'<tbody>'
            +'<tr>'
              +'<td>'+ket_umur+'</td>'
              +'<td>'+tinggi+' cm</td>'
              +'<td>'+ket_tinggi+'</td>'
              +'<td>'+berat+'</td>'
              +'<td>'+ket_berat+'</td>'
            +'</tr>'
          +'</tbody>'
        +'</table>'
      jQuery('#staticBackdrop .modal-body').html(table);
      jQuery('#staticBackdrop').modal('show');
    });
  });

</script>