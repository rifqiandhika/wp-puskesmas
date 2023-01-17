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
        <label for="">Masukan Data Umum</label>
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
    <div class="modal-footer text-center">
    <button class="btn btn-primary" id="simpan">Simpan</button>
    </div>
    </div>
</form>
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
      var berat = +jQuery("input[name='berat-badan']").val();
      var tinggi = +jQuery("input[name='tinggi-badan']").val();
      umur = _calculateAge(umur);
      if(
        umur >= 0
        && umur <= 0.5
      ){
        alert('umur dibawah 6 bulan');
        if(
          berat>=3.3
          && berat<=7.9
        ){
          alert('berat '+berat+' ideal.');
        }else{
          alert('berat '+berat+' tidak ideal.');
        }
        if(
          tinggi>=49.9
          && tinggi<=67.6
        ){
          alert('tinggi '+tinggi+' ideal');
        }else{
          alert('tinggi '+tinggi+' tidak ideal');
        }
      }else if(
        umur >= 0.5
        && umur < 1
      ){
        alert('umur 7-11 Bulan');
      }else if(
        umur >= 1
        && umur <= 3
      ){
        alert('umur 1-3 Tahun');
      }else if(
        umur >= 4
        && umur <= 6
      ){
        alert('umur 4-6 Tahun');
      }else if(
        umur >= 7
        && umur <= 12
      ){
        alert('umur 7-12 Tahun');
      }else if(
        umur >= 13
        && umur <= 18
      ){
        alert('umur 13-18 Tahun');
      }
    })
  })
</script>