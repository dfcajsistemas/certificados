<div>
    <div class="row">

        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{$nusu}}</h3>

                    <p>Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <a href="{{route('accesos')}}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-sm-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{$nest}}</h3>

                    <p>Estudiantes</p>
                    </div>
                    <div class="icon">
                    <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <a href="{{route('estudiantes')}}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-sm-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>{{$ncap}}</h3>

                    <p>Capacitaciones</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <a href="{{route('capacitaciones')}}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-sm-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                    <h3>{{$ncer}}</h3>

                    <p>Certificados</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                    <a href="{{route('capacitaciones')}}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
        <div class="col-sm-6 mb-2">
            <img src="{{asset('img/cer.jpg')}}" class="img-fluid">
        </div>
    </div>
</div>
