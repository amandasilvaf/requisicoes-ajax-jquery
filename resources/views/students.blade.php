<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

    <section style="padding-top:60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Alunos</h4> <a href="#" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#studentModal">Adicionar</a>
                        </div>
                        <div class="card-body">
                            <table id="studentTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Sobrenome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr id="sid{{$student->id}}">
                                            <td>{{$student->firstname}}</td>
                                            <td>{{$student->lastname}}</td>
                                            <td>{{$student->email}}</td>
                                            <td>{{$student->phone}}</td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="editStudent({{$student->id}})" class="btn btn-primary btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         {{--  Editar  --}}
    <div class="modal fade" id="studentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="studentEditForm">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="firstname">Nome</label>
                        <input type="text" class="form-control" id="firstname2">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome</label>
                        <input type="text" class="form-control" id="lastname2">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email2">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control" id="phone2">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
    

    </section>

     {{--  Adicionar  --}}
     <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="studentForm">
                    @csrf
                    <div class="form-group">
                        <label for="firstname">Nome</label>
                        <input type="text" class="form-control" id="firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome</label>
                        <input type="text" class="form-control" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control" id="phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
  


    <script>
        $("#studentForm").submit(function(event){
            event.preventDefault();

            let firstname = $('#firstname').val();
            let lastname = $('#lastname').val();
            let email = $('#email').val();
            let phone = $('#phone').val();
            let _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{route('student.add')}}",
                type: "POST",
                data: {
                    firstname:firstname,
                    lastname:lastname,
                    email:email,
                    phone:phone,
                    _token:_token
                },
                success: function(response)
                {
                    if(response)
                    {
                        console.log(response);
                        $("#studentTable>tbody").prepend('<tr><td>'+ response.firstname +'</td><td>'+response.lastname+'</td><td>'+response.email+'</td><td>'+response.phone+'</td></tr>');
                        $("#studentForm")[0].reset();
                        $("#studentModal").modal('hide');
                    }
                }
            });

        });
    </script>

    <script>
        function editStudent(id)
        {
            $.get('/students/'+id, function(student){
                $('#id').val(student.id);
                $('#firstname2').val(student.firstname);
                $('#lastname2').val(student.lastname);
                $('#email2').val(student.email);
                $('#phone2').val(student.phone);
                $('#studentEditModal').modal('toggle');
            });
        }

        $("#studentEditForm").submit(function(event){
            event.preventDefault();

            let id = $("#id").val();
            let firstname = $('#firstname2').val();
            let lastname = $('#lastname2').val();
            let email = $('#email2').val();
            let phone = $('#phone2').val();
            let _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{ route('student.update')}}",
                type: "PUT",
                data:{
                    id:id,
                    firstname:firstname,
                    lastname:lastname,
                    email:email,
                    phone:phone,
                    _token:_token
                },
                success: function(response)
                {
                    $('#sid' + response.id + 'td:nth-child(1)').text(response.firstname); 
                    $('#sid' + response.id + 'td:nth-child(2)').text(response.lastname);
                    $('#sid' + response.id + 'td:nth-child(3)').text(response.email); 
                    $('#sid' + response.id + 'td:nth-child(4)').text(response.phone);  
                    $('#studentEditModal').modal('toggle');
                    $('#studentEditForm')[0].reset();
                }
            });
        });

    </script>

</body>
</html>