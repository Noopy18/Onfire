<?php  
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Perfil | OnFire';
?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                
                <form method="post" action="<?= Url::to(['profile/index']) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                
                    <!-- PROFILE HEADER -->
                    <div class="text-center mb-5">

                        <div class="position-relative d-inline-block">
                            <img src="<?= Url::to($utilizador->getProfilePictureUrl()) ?>"
                                class="rounded-circle border border-3 border-light shadow-sm"
                                style="width: 150px; height: 150px; object-fit: cover;">

                            <label for="profileImageUpload" 
                                class="btn btn-sm btn-success position-absolute bottom-0 end-0 rounded-circle">
                                <i class="bi bi-camera-fill"></i>
                            </label>

                            <input type="file" 
                                id="profileImageUpload"
                                name="profile_picture"
                                class="d-none"
                                accept="image/*"
                                onchange="previewImage(this)">
                        </div>
                        
                        <div class="mt-3">
                            <span class="h4 fw-bold"><?= Html::encode($user->username) ?></span>
                        </div>
                    </div>

                    <!-- SETTINGS SECTION -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <h5 class="mb-4 text-center">Definições da Conta</h5>

                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Nome:</label>
                                </div>
                                <div class="col-6">
                                    <label id="usernameDisplay" class="form-label fw-semibold"><?= $user->username?></label>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <button type="button" id="editUsernameBtn" class="btn btn-sm btn-outline-secondary ms-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Nome:</label>
                                </div>
                                <div class="col-6">
                                    <label id="nameDisplay" class="form-label fw-semibold"><?= $utilizador->name?></label>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <button type="button" id="editNameBtn" class="btn btn-sm btn-outline-secondary ms-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Password:</label>
                                </div>
                                <div class="col-9">
                                    <a href="<?= Url::to(['site/request-password-reset']) ?>" 
                                        class="btn btn-outline-primary w-100">
                                        Alterar password
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-3" hidden>
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Nome:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" 
                                        name="username"
                                        id="usernameInput"
                                        class="form-control" 
                                        value="<?= Html::encode($user->username) ?>"
                                        placeholder="Enter new username">
                                </div>
                            </div>

                            <div class="row mb-3" hidden>
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Nome:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" 
                                        name="name"
                                        id="nameInput"
                                        class="form-control" 
                                        value="<?= Html::encode($utilizador->name) ?>"
                                        placeholder="Enter new name">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-3">
                                    <label class="form-label fw-semibold">Privacidade:</label>
                                </div>
                                <div class="col-9">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="private_profile" value="0">
                                        <input class="form-check-input" type="checkbox" id="privateProfile" name="private_profile" value="1" <?php if($utilizador->private_profile){ echo "checked";} ?>>
                                        <label class="form-check-label" for="privateProfile">
                                            Perfil Privado
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 py-2" 
                                    style="background-color: #ff7b00; color: white;">
                                Guardar Alterações  
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('img[style*="width: 150px"]');
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            
            // Auto-submit the image form
            document.getElementById('imageForm').submit();
        }
    }

    function privateProfile() {
        const privateInput = document.getElementById('privateProfile');
        if (!privateInput) return;

        privateInput.value = privateInput.checked ? "1" : "0";
        
        privateInput.addEventListener('change', function() {
            this.value = this.checked ? "1" : "0";
        });
    }

    function setupUsernameEdit() {
        const editBtn = document.getElementById('editUsernameBtn');
        if (!editBtn) return;
        
        editBtn.addEventListener('click', function() {
            const usernameDisplay = document.getElementById('usernameDisplay');
            const currentUsername = usernameDisplay.textContent;
            
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentUsername;
            input.className = 'form-control d-inline-block';
            input.style.width = 'auto';
            input.style.minWidth = '200px';
            
            usernameDisplay.replaceWith(input);
            input.focus();
            
            const saveBtn = document.createElement('button');
            saveBtn.type = 'button';
            saveBtn.className = 'btn btn-sm btn-success ms-2';
            saveBtn.innerHTML = '<i class="bi bi-check"></i>';
            
            this.replaceWith(saveBtn);
            
            saveBtn.addEventListener('click', function() {
                const newLabel = document.createElement('label');
                newLabel.id = 'usernameDisplay';
                newLabel.className = 'form-label fw-semibold';
                newLabel.textContent = input.value;
                
                input.replaceWith(newLabel);
                
                const newEditBtn = document.createElement('button');
                newEditBtn.type = 'button';
                newEditBtn.id = 'editUsernameBtn';
                newEditBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
                newEditBtn.innerHTML = '<i class="bi bi-pencil"></i>';
                
                saveBtn.replaceWith(newEditBtn);
                
                // Update the username input in the form
                document.getElementById('usernameInput').value = input.value;
                
                // Re-setup event listener
                setupUsernameEdit();
            });
        });
    }

    function setupNameEdit() {
        const editBtn = document.getElementById('editNameBtn');
        if (!editBtn) return;
        
        editBtn.addEventListener('click', function() {
            const nameDisplay = document.getElementById('nameDisplay');
            const currentName = nameDisplay.textContent;
            
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentName;
            input.className = 'form-control d-inline-block';
            input.style.width = 'auto';
            input.style.minWidth = '200px';
            
            nameDisplay.replaceWith(input);
            input.focus();
            
            const saveBtn = document.createElement('button');
            saveBtn.type = 'button';
            saveBtn.className = 'btn btn-sm btn-success ms-2';
            saveBtn.innerHTML = '<i class="bi bi-check"></i>';
            
            this.replaceWith(saveBtn);
            
            saveBtn.addEventListener('click', function() {
                const newLabel = document.createElement('label');
                newLabel.id = 'nameDisplay';
                newLabel.className = 'form-label fw-semibold';
                newLabel.textContent = input.value;
                
                input.replaceWith(newLabel);
                
                const newEditBtn = document.createElement('button');
                newEditBtn.type = 'button';
                newEditBtn.id = 'editNameBtn';
                newEditBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
                newEditBtn.innerHTML = '<i class="bi bi-pencil"></i>';
                
                saveBtn.replaceWith(newEditBtn);
                
                // Update the name input in the form
                document.getElementById('nameInput').value = input.value;
                
                // Re-setup event listener
                setupNameEdit();
            });
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', setupNameEdit);
    document.addEventListener('DOMContentLoaded', setupUsernameEdit);
    document.addEventListener('DOMContentLoaded', privateProfile);
</script>
