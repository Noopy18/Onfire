<?php
use yii\helpers\Html;

$this->title = 'Amigos | OnFire';
?>

<div class="container-fluid py-4">

    <div class="row g-4">

        <!-- Barra de pesquisa -->
        <div class="col-12">
            <input type="text" id="searchUser" class="form-control rounded-pill p-3 mb-3"
                placeholder="Pesquisar utilizador...">
            <ul id="searchResults" class="list-group mb-4" style="display:none;"></ul>
        </div>

        <!-- Lista de amigos -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Friends</h5>

                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center rounded-pill mb-2">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="Avatar">
                            <span class="fw-semibold">Friend</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Detalhes do amigo -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">

                    <!-- Avatar e badges -->
                    <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
                        <img src="https://via.placeholder.com/100" class="rounded-circle" alt="Avatar">

                        <div class="d-flex align-items-center gap-2">
                            <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px;">
                                <small class="text-center lh-sm">Current<br>Streak</small>
                            </div>
                            <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px;">
                                <small>Conquista</small>
                            </div>
                            <div class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px;">
                                <small>Conquista</small>
                            </div>
                        </div>
                    </div>

                    <!-- Nome -->
                    <div class="bg-light p-2 rounded-3 mb-3">
                        <h5 class="mb-0 fw-semibold">Nome do utilizador</h5>
                    </div>

                    <!-- Descrição -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <p class="mb-0 text-muted">Descrição do utilizador.</p>
                    </div>

                    <!-- Botão remover -->
                    <div class="text-end">
                        <button class="btn btn-outline-danger rounded-pill px-4">Remover de amigo</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<script>
document.getElementById('searchUser').addEventListener('keyup', function () {
    let q = this.value.trim();

    if (q.length === 0) {
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('searchResults').innerHTML = '';
        return;
    }

    fetch('index.php?r=site/search-users&q=' + q)
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('searchResults');
            container.innerHTML = '';
            container.style.display = 'block';

            data.forEach(user => {
                container.innerHTML += `
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="${user.avatar}" class="rounded-circle me-3" width="40">
                            <strong>${user.username}</strong>
                        </div>
                        <button class="btn btn-sm btn-success rounded-pill"
                                onclick="addFriend(${user.id})">
                            Adicionar
                        </button>
                    </li>
                `;
            });
        });
});

function addFriend(id) {
    fetch('index.php?r=site/add-friend&id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Amigo adicionado!');
                document.getElementById('searchUser').value = '';
                document.getElementById('searchResults').style.display = 'none';
            } else {
                alert(data.message);
            }
        });
}
</script>
