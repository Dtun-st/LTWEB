const editBtn = document.getElementById('editBtn');
const saveBtn = document.getElementById('saveBtn');
const cancelBtn = document.getElementById('cancelBtn');

const avatarImg = document.getElementById('avatarImg');
const avatarInput = document.getElementById('avatarInput');
const removeAvatarBtn = document.getElementById('removeAvatarBtn');
const avatarContainer = document.querySelector('.avatar');

const defaultAvatar = './resources/avatar.png';
avatarImg.src = defaultAvatar;

// Các trường được phép sửa
const editableFields = ['username', 'email'];

// Bắt đầu chỉnh sửa
editBtn.addEventListener('click', () => {
  editableFields.forEach(field => {
    document.getElementById(`${field}Text`).style.display = 'none';
    document.getElementById(`${field}Input`).style.display = 'block';
  });

  editBtn.style.display = 'none';
  saveBtn.style.display = 'inline-block';
  cancelBtn.style.display = 'inline-block';

  // Cho phép chỉnh avatar
  avatarContainer.classList.add('editable');

  // Hiện nút xóa ảnh nếu ảnh hiện tại không phải mặc định
  const currentSrc = new URL(avatarImg.src, location.href).href;
  const defaultSrc = new URL(defaultAvatar, location.href).href;
  if (currentSrc !== defaultSrc) {
    removeAvatarBtn.style.display = 'inline-block';
  }
});

// Hủy chỉnh sửa
cancelBtn.addEventListener('click', () => {
  editableFields.forEach(field => {
    document.getElementById(`${field}Text`).style.display = 'block';
    document.getElementById(`${field}Input`).style.display = 'none';
    document.getElementById(`${field}Input`).value = document.getElementById(`${field}Text`).innerText;
  });

  editBtn.style.display = 'inline-block';
  saveBtn.style.display = 'none';
  cancelBtn.style.display = 'none';

  avatarContainer.classList.remove('editable');

  // Nếu đã chọn ảnh, quay lại ảnh mặc định
  const currentSrc = new URL(avatarImg.src, location.href).href;
  const defaultSrc = new URL(defaultAvatar, location.href).href;
  if (currentSrc !== defaultSrc) {
    avatarImg.src = defaultAvatar;
  }

  removeAvatarBtn.style.display = 'none';
});

// Lưu thông tin
document.getElementById('infoForm').addEventListener('submit', (e) => {
  e.preventDefault();

  editableFields.forEach(field => {
    const newValue = document.getElementById(`${field}Input`).value;
    document.getElementById(`${field}Text`).innerText = newValue;
    document.getElementById(`${field}Text`).style.display = 'block';
    document.getElementById(`${field}Input`).style.display = 'none';
  });

  editBtn.style.display = 'inline-block';
  saveBtn.style.display = 'none';
  cancelBtn.style.display = 'none';

  avatarContainer.classList.remove('editable');

  // Ẩn nút xóa ảnh sau khi lưu
  removeAvatarBtn.style.display = 'none';
});

// Đổi avatar khi được phép
avatarImg.addEventListener('click', () => {
  if (avatarContainer.classList.contains('editable')) {
    avatarInput.click();
  }
});

avatarInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      avatarImg.src = reader.result;

      // Hiện nút xóa ảnh sau khi chọn
      removeAvatarBtn.style.display = 'inline-block';
    };
    reader.readAsDataURL(file);
  }
});

// Xóa avatar: quay lại avatar mặc định
removeAvatarBtn.addEventListener('click', () => {
  avatarImg.src = defaultAvatar;
  avatarInput.value = '';
  removeAvatarBtn.style.display = 'none';
});
