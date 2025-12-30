@auth
<!-- Tombol Akun -->
<div class="account-container">
  <button onclick="toggleDropdown()" class="account-btn">
    <img src="{{asset ('foto/asset/person-circle.svg')}}" alt="Akun" width="24">
  </button>

  <!-- Dropdown -->
  <div id="accountDropdown" class="account-dropdown">
    <ul>
      <li><a href="/profile">Profil</a></li>
      @if(Auth::user()->role === 'customer')
      <li><a href="/pesanan-saya">Pesanan Saya</a></li>
      @endif
      <li>
        <form method="GET" action="/sesi/logout" onsubmit="return confirmLogout()">
          @csrf
          <button type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</div>

<style>
  .account-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
  }

  .account-btn {
    background-color: white;
    border: none;
    border-radius: 50%;
    padding: 12px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s;
  }

  .account-btn:hover {
    background-color: yellowgreen;
  }

  .account-dropdown {
    display: none;
    position: absolute;
    bottom: 60px;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 180px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    animation: fadeSlideIn 0.3s ease-out;
  }


  .account-dropdown ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .account-dropdown li {
    border-bottom: 1px solid #f0f0f0;
  }

  .account-dropdown li:last-child {
    border-bottom: none;
  }

  .account-dropdown a,
  .account-dropdown button {
    display: block;
    width: 100%;
    padding: 10px 15px;
    text-align: left;
    background: none;
    border: none;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .account-dropdown a:hover,
  .account-dropdown button:hover {
    background-color: #f9f9f9;
    border-radius: 20px

  }

  @keyframes fadeSlideIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<script>
  function toggleDropdown() {
    const dropdown = document.getElementById('accountDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
  }

  window.addEventListener('click', function (e) {
    const dropdown = document.getElementById('accountDropdown');
    const button = document.querySelector('.account-btn');
    if (!dropdown.contains(e.target) && !button.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });

  function confirmLogout() {
    return confirm("Apa kamu yakin ingin logout?");
  }
</script>
@endauth
