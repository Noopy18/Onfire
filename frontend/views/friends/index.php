<?php
use yii\helpers\Html;

$this->title = 'Amigos | OnFire';
?>

<div class="container-fluid py-4">

    <div class="row g-4">

        <!-- Lista de amigos -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <!-- Botões de navegação -->
                    <div class="btn-group w-100 mb-4" role="group">
                        <button type="button" class="btn btn-outline-primary active" onclick="showTab('amigos')">Amigos</button>
                        <button type="button" class="btn btn-outline-primary" onclick="showTab('pendente')">Pendente</button>
                        <button type="button" class="btn btn-outline-primary" onclick="showTab('pesquisar')">Pesquisar</button>
                    </div>

                    <!-- Tab Amigos -->
                    <div id="tab-amigos" class="tab-content">
                        <div class="list-group">
                            <?php if (empty($friends)): ?>
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <p class="mb-0">Ainda não tens amigos adicionados.</p>
                                </div>
                            <?php else: ?>
                                
                                <?php foreach ($friends as $friend): ?>

                                    <?= Html::beginForm(['friends/index', 'friend_id' => $friend->id], 'post', ['class' => 'mb-2']) ?>
                                        <button type="submit" class="list-group-item list-group-item-action d-flex align-items-center border-0 rounded-3 shadow-sm w-100 p-3" style="background: none; border: none;">
                                            <img src="https://via.placeholder.com/45" class="rounded-circle me-3" alt="Avatar">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-semibold"><?= Html::encode($friend->username) ?></h6>
                                                <?php 
                                                    $bestStreak = 0;
                                                    if ($friend->utilizador->habits) {
                                                        foreach ($friend->utilizador->habits as $habit) {
                                                            $streak = $habit->getBestStreak();
                                                            if ($streak > $bestStreak) {
                                                                $bestStreak = $streak;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <small class="text-muted">Melhor Streak: <?= $bestStreak ?></small>
                                            </div>
                                        </button>
                                    <?= Html::endForm() ?>   
                                
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab Pendente -->
                    <div id="tab-pendente" class="tab-content" style="display:none;">
                        <div class="list-group">
                            <?php 
                            $hasPendingRequests = false;
                            foreach ($dataProvider->getModels() as $friendRequest) {
                                if ($friendRequest->status !== \frontend\models\Friends::STATUS_PENDENTE) {
                                    continue;
                                }
                                $hasPendingRequests = true;
                            ?>
                                <div class="list-group-item border-0 rounded-3 mb-2 shadow-sm">
                            
                                    <?php
                                        if ($friendRequest->receiver == Yii::$app->user->id){
                                    ?>
                                        <div class="d-flex mb-2">
                                            <?= Html::beginForm(['friends/index', 'friend_id' => $friendRequest->sender], 'post', ['class' => 'flex-grow-1']) ?>
                                                <button type="submit" class="btn btn-light d-flex align-items-center w-100 p-3 border-0 shadow-sm" style="border-radius: 0.75rem 0 0 0.75rem;">
                                                    <img src="https://via.placeholder.com/45" class="rounded-circle me-3" alt="Avatar">
                                                    <div class="flex-grow-1 text-start">
                                                        <h6 class="mb-0 fw-semibold"><?= $users::findOne($friendRequest->sender)->username ?></h6>
                                                        <small class="text-muted">Pedido de amizade</small>
                                                    </div>
                                                </button>
                                            <?= Html::endForm() ?>
                                            <div class="d-flex align-items-stretch">
                                                <?= Html::beginForm(['friends/respond-to-invitation', 'senderId' => $friendRequest->sender, 'action' => 'accepted'], 'post', ['style' => 'display: flex; height: 100%;']) ?>
                                                    <?= Html::submitButton('Aceitar', ['class' => 'btn btn-success border-0 shadow-sm px-3 h-100', 'style' => 'border-radius: 0;']) ?>
                                                <?= Html::endForm() ?>
                                                <?= Html::beginForm(['friends/respond-to-invitation', 'senderId' => $friendRequest->sender, 'action' => 'declined'], 'post', ['style' => 'display: flex; height: 100%;']) ?>
                                                    <?= Html::submitButton('Recusar', ['class' => 'btn btn-danger border-0 shadow-sm px-3 h-100', 'style' => 'border-radius: 0 0.75rem 0.75rem 0;']) ?>
                                                <?= Html::endForm() ?>
                                            </div>
                                        </div>
                                    <?php
                                        } else {
                                    ?>
                                        <div class="d-flex mb-2">
                                            <?= Html::beginForm(['friends/index', 'friend_id' => $users::findOne($friendRequest->receiver)->id], 'post', ['class' => 'flex-grow-1']) ?>
                                                <button type="submit" class="btn btn-light d-flex align-items-center w-100 p-3 border-0 shadow-sm" style="border-radius: 0.75rem 0 0 0.75rem;">
                                                <img src="https://via.placeholder.com/45" class="rounded-circle me-3" alt="Avatar">
                                                    <div class="flex-grow-1 text-start">
                                                        <h6 class="mb-0 fw-semibold"><?= Html::encode($users::findOne($friendRequest->receiver)->username) ?></h6>
                                                    <?php 
                                                        $bestStreak = 0;
                                                            if ($users::findOne($friendRequest->receiver)->utilizador->habits) {
                                                                foreach ($users::findOne($friendRequest->receiver)->utilizador->habits as $habit) {
                                                                $streak = $habit->getBestStreak();
                                                                if ($streak > $bestStreak) {
                                                                    $bestStreak = $streak;
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <small class="text-muted">Melhor Streak: <?= $bestStreak ?></small>
                                                </div>
                                            </button>
                                        <?= Html::endForm() ?>
                                            <div class="btn btn-info d-flex align-items-center px-3 border-0 shadow-sm" style="border-radius: 0 0.75rem 0.75rem 0; pointer-events: none;">
                                                <small class="text-white fw-semibold">Pendente</small>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php if (!$hasPendingRequests): ?>
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <p class="mb-0">Nenhum pedido de amizade pendente.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab Pesquisar -->
                    <div id="tab-pesquisar" class="tab-content" style="display:none;">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchUser" class="form-control border-start-0 rounded-end-pill" 
                                placeholder="Pesquisar utilizador...">
                        </div>
                        <div id="searchResults" class="list-group" style="display:none;"></div>
                        <div id="searchEmpty" class="text-center text-muted py-4" style="display:none;">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <p class="mb-0">Nenhum utilizador encontrado.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Detalhes do amigo -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <?php if ($friend_id != -1): ?>
                <div class="card-header bg-gradient text-success text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1rem 1rem 0 0 !important;">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://via.placeholder.com/120" class="rounded-circle border border-4 border-white shadow" alt="Avatar" style="min-width: 120px; min-height: 120px; object-fit: cover;">
                    </div>
                    <h4 class="mb-1 fw-bold"><?= $users::findOne($friend_id)->username ?></h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Stats Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="card bg-primary bg-opacity-10 border-0 text-center py-3">
                                <div class="card-body p-2">
                                    <i class="fas fa-fire text-primary fs-3 mb-2"></i>
                                    <h5 class="mb-0 fw-bold text-primary">15</h5>
                                    <small class="text-muted">Streak Atual</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-success bg-opacity-10 border-0 text-center py-3">
                                <div class="card-body p-2">
                                    <i class="fas fa-trophy text-success fs-3 mb-2"></i>
                                    <h5 class="mb-0 fw-bold text-success">8</h5>
                                    <small class="text-muted">Conquistas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-warning bg-opacity-10 border-0 text-center py-3">
                                <div class="card-body p-2">
                                    <i class="fas fa-calendar-check text-warning fs-3 mb-2"></i>
                                    <h5 class="mb-0 fw-bold text-warning">45</h5>
                                    <small class="text-muted">Dias Ativos</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-user me-2 text-muted"></i>Sobre
                            </h6>
                            <p class="card-text text-muted mb-0">Apaixonado por criar hábitos saudáveis e manter streaks consistentes. Sempre em busca de novos desafios!</p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-clock me-2 text-muted"></i>Atividade Recente
                            </h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-success rounded-circle me-3" style="width: 8px; height: 8px;"></div>
                                <small class="text-muted">Completou "Exercício Matinal" há 2 horas</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle me-3" style="width: 8px; height: 8px;"></div>
                                <small class="text-muted">Alcançou streak de 15 dias em "Leitura"</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-3" style="width: 8px; height: 8px;"></div>
                                <small class="text-muted">Desbloqueou conquista "Consistente" ontem</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <?php if($utilizadores->friendshipWith($friend_id) != null &&
                    $utilizadores->friendshipWith($friend_id)->status == 'aceite'): ?>
                        <div class="d-flex gap-2 justify-content-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <?php
                                    echo Html::beginForm(['friends/end-friendship', 'id' => $friend_id], 'post');
                                    echo Html::submitButton(
                                        '<i class="fas fa-user-minus me-2"></i>Remover amigo.',
                                        ['class' => 'btn btn-outline-danger rounded-pill px-4']
                                    );
                                    echo Html::endForm();
                                
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($utilizadores->friendshipWith($friend_id) != null &&
                        $utilizadores->friendshipWith($friend_id)->status == 'pendente'): ?>
                        <div class="d-flex gap-2 justify-content-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <?php
                                    
                                    echo Html::submitButton(
                                        '<i class="fas fa-user me-2"></i>Pedido pendente.',
                                        ['class' => 'btn btn-info rounded-pill px-4']
                                    );
                                
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($utilizadores->friendshipWith($friend_id) == null): ?>
                        <div class="d-flex gap-2 justify-content-end">
                            <?php
                                echo Html::beginForm(['friends/friendship-invitation', 'id' => $friend_id], 'post');
                                echo Html::submitButton(
                                    '<i class="fas fa-user-plus me-2"></i> Mandar pedido de amizade.',
                                    ['class' => 'btn btn-success rounded-pill px-4']
                                );
                                echo Html::endForm();
                            
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<script>
    function showTab(tabName) {

        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById('tab-' + tabName).style.display = 'block';
        
        // Add active class to clicked button
        event.target.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchUser');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                let q = this.value.trim();

                if (q.length === 0) {
                    document.getElementById('searchResults').style.display = 'none';
                    document.getElementById('searchResults').innerHTML = '';
                    return;
                }

                fetch('<?= \yii\helpers\Url::to(['friends/search-users']) ?>?q=' + q)
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('searchResults');
                    const emptyContainer = document.getElementById('searchEmpty');
                    
                    resultsContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultsContainer.style.display = 'none';
                        emptyContainer.style.display = 'block';
                    } else {
                        emptyContainer.style.display = 'none';
                        resultsContainer.style.display = 'block';
                        
                        data.forEach(user => {
                            const userItem = document.createElement('div');
                            
                            userItem.innerHTML = `
                                <form action="<?= \yii\helpers\Url::to(['friends/index']) ?>?friend_id=${user.id}" method="post" class="mb-2">
                                    <input type="hidden" name="friend_id" value="${user.id}">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                                    <button type="submit" class="list-group-item list-group-item-action d-flex align-items-center border-0 rounded-3 shadow-sm w-100 p-3" style="background: none; border: none;">
                                        <img src="https://via.placeholder.com/45" class="rounded-circle me-3" alt="Avatar">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-semibold">${user.username}</h6>
                                        </div>
                                    </button>
                                </form>  
                            `;
                            resultsContainer.appendChild(userItem);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let container = document.getElementById = document.getElementById('searchResults');
                    container.innerHTML = '';
                    container.style.display = 'block';
                });
            });
        }
    });
</script>
