

<div class="p2">
    <form action="{{ route('karyawan.update',base64_encode($data->id)) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group">
        	<label style="margin-bottom: 0.5px">NIk :</label>
        	<input value="{{ $data->nik }}" type="text" id="nik" name="nik" class="form-control mb-2" placeholder="nik ?" required>
        	<label style="margin-bottom: 0.5px">Name :</label>
        	<input value="{{ $data->nama }}" type="text" id="nama" name="nama" class="form-control mb-2" placeholder="nama ?" required>
        	<label style="margin-bottom: 0.5px">Email :</label>
        	<input value="{{ $data->email }}" type="text" id="email" name="email" class="form-control mb-2" placeholder="email ?">
        	<label style="margin-bottom: 0.5px">Departemen :</label>
        	<input value="{{ $data->departemen }}" type="text" id="departemen" name="departemen" class="form-control mb-2" placeholder="departemen ?">
        	<label style="margin-bottom: 0.5px">Tgl Lahir :</label>
        	<input value="{{ $data->tgl_lahir }}" type="date" id="tgl_lahir" name="tgl_lahir" class="form-control mb-2" placeholder="tgl lahir ?">
        	<label style="margin-bottom: 0.5px">No Hp/Wa :</label>
        	<input value="{{ $data->no_hp }}" type="text" id="no_hp" name="no_hp" class="form-control mb-2" placeholder="handphone ?">
        </div>
        <div class="footer">
            <button class="btn btn-primary" type="submit">save</button>
        </div>
    </form>
</div>
