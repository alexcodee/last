<a href="<?= base_url('petugas/tambah_petugas') ?>" class="btn btn-sm-6 btn-success mb-4">Tambah Petugas</a>

<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Petugas</th>
            <th>Username</th>
            <th>Telepon</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($petugas as $ptgs) {

            echo ' <tr>
                <td>' . $no . '</td>
                <td>' . $ptgs['nama_petugas'] . '</td>
                <td>' . $ptgs['username'] . '</td>
                <td>' . $ptgs['telp'] . '</td>
               
                
            </tr>';
            $no++;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nama Petugas</th>
            <th>Username</th>
            <th>Telepon</th>
        </tr>
    </tfoot>
</table>