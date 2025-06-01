<?php
include("invcode.php");
include("code/loginC.php");
include_once("code/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catálogo de Árvores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="">
  <style>
    .product-card img {
      height: 200px;
      object-fit: cover;
    }
    .badge-new {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: red;
      color: white;
    }
    .product-card {
      position: relative;
      transition: transform 0.2s ease-in-out;
    }
    .product-card:hover {
      transform: scale(1.03);
    }

    /* Animação dos cards */
    .animate-fade {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.5s forwards;
    }
    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Animação de botões */
    button {
      transition: all 0.2s ease-in-out;
    }
    button:hover {
      transform: scale(1.05);
    }
    button:active {
      transform: scale(0.95);
    }

    /* Carrinho animado */
    #cart {
      max-height: 0;
      overflow: hidden;
      opacity: 0;
      transition: all 0.4s ease;
    }
    #cart.open {
      max-height: 500px;
      opacity: 1;
    }

    :root {
            --primary: #3a7d44;
            --secondary: #2d5a34;
            --accent: #5cb85c;
            --light: #f8f9fa;
            --dark: #343a40;
        }
nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .nav-links {
          list-style: none;
          display: flex;
          gap: 30px;
          margin: 0;
          padding: 0;
          font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
      
        .nav-links li a {
          color: #fff;
          font-weight: 300;
          font-size: 1em;
          text-decoration: none;
          padding: 8px 0;
          position: relative;
          transition: color 0.3s ease;
        }
      
        .nav-links li a::after {
          content: '';
          position: absolute;
          width: 0%;
          height: 2px;
          bottom: 0;
          left: 0;
          background-color: #fff;
          transition: width 0.3s ease;
        }
      
        .nav-links li a:hover,
        .nav-links li a:focus {
          color: #bbb;
        }
      
        .nav-links li a:hover::after,
        .nav-links li a:focus::after {
          width: 100%;
        }
      
        @media (max-width: 768px) {
          .nav-links {
            gap: 15px;
            font-size: 0.9em;
          }
        }
        /* Dropdown container */
      .dropdown {
        position: relative;
      }
      
      /* Link principal do dropdown */
      .dropbtn {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #fff;
        font-weight: 300;
        font-size: 1em;
        text-decoration: none;
        padding: 8px 0;
        position: relative;
        transition: color 0.3s ease;
      }
      
      /* Seta ao lado do texto */
      .seta {
        font-size: 0.6em;
        line-height: 1;
        transition: transform 0.3s ease;
        display: inline-block;
      }
      
      /* Submenu escondido por padrão */
      .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        background: #000;
        border: 1px solid #444;
        border-radius: 6px;
        list-style: none;
        padding: 8px 0;
        margin: 8px 0 0 0;
        min-width: 140px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 10;
      }
      
      /* Itens do submenu */
      .submenu li a {
        display: block;
        padding: 8px 20px;
        color: #fff;
        font-weight: 300;
        font-size: 0.95em;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color 0.3s ease;
      }
      
      .submenu li a:hover {
        background-color: #222;
      }
      
      /* Mostrar submenu ao passar o mouse */
      .dropdown:hover .submenu,
      .dropdown:focus-within .submenu {
        opacity: 1;
        visibility: visible;
      }
      
      /* Seta rotaciona ao abrir */
      .dropdown:hover .seta,
      .dropdown:focus-within .seta {
        transform: rotate(180deg);
      }
      
      /* Mantém a linha embaixo do texto no hover do link principal */
      .dropbtn::after {
        content: '';
        position: absolute;
        width: 0%;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #fff;
        transition: width 0.3s ease;
      }
      
      .dropbtn:hover::after,
      .dropbtn:focus::after {
        width: 100%;
      }
      .toggle-theme {
        background-color: var(--btn-bg);
        color: var(--btn-color);
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        flex-shrink: 0;
        font-family: 'Roboto', sans-serif;
      }
      
      .toggle-theme:hover {
        background-color: var(--btn-hover);
      }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light shadow-sm mb-4">
   <div class="container d-flex justify-content-between">
            <?php 
                if(isset($_SESSION['nome'])){ ?>
            <a href="inipage.php" class="logo">Treedom</a><?php } else{ ?>
                <a href="index.html" class="logo">Treedom</a>
              <?php } ?>
            <ul class="nav-links">
                <li><a href="#">Nosso Trabalho</a></li>
                <li><a href="#">Sobre</a></li>
                <li><a href="#">Porque árvores?</a></li>
                <li><a href="galeria.html">Galeria</a></li>
                        <li class="dropdown">
                <?php 
                if(isset($_SESSION['nome'])){ ?>
                  <a><?php echo $_SESSION['nome'];?></a>
                <ul class="submenu">
              <li><a href="inventario.php">inventário<span ></span></a></li>
            <li><a href="code/logout.php">Sair<span ></span></a></li>
              <?php } else{ ?>
                <a href="#">Login/Cadastro <span class="seta">&#9660;</span></a>
        <ul class="submenu">
          <li><a href="login.php">Login</a></li>
          <li><a href="cadastro.php">Cadastro</a></li>
        </ul>
        </li> <?php } ?>


                <!-- <?php if(isset($_SESSION['nome'])){
                  
                  echo $_SESSION['nome'];
                  
                  }else{ ?>
                <li><a href="login.php">Login</a></li>
               <?php } ?>
            </ul> -->
      
  
    
  
  </div>
</nav>
<button style="margin-left: 4em;" class="btn btn-outline-success" onclick="toggleCart()">🛒 Carrinho (<span id="cartCount">0</span>)</button>


<!-- Header -->
<div class="text-center bg-light p-5 mb-4">
  <h1 class="display-5">Catálogo de Árvores</h1>
  <p class="lead">Escolha uma árvore para plantar no mundo real!</p>
</div>

<!-- Filters -->
<div class="container mb-4">
  <div class="row g-2">
    <div class="col-md-3">
      <select id="filterCategory" class="form-select">
        <option value="">Todas as Categorias</option>
        <option value="interior">Interior</option>
        <option value="exterior">Exterior</option>
      </select>
    </div>
    <div class="col-md-3">
      <select id="filterPrice" class="form-select">
        <option value="">Todos os Preços</option>
        <option value="1">Até R$50</option>
        <option value="2">R$50 - R$100</option>
        <option value="3">Acima de R$100</option>
      </select>
    </div>
    <div class="col-md-6">
      <input type="text" id="filterSearch" class="form-control" placeholder="Buscar árvore...">
    </div>
  </div>
</div>

<!-- Carrinho -->
<div class="container mb-4">
  <div id="cart" class="card p-3 shadow-sm">
    <h5>Carrinho</h5>
    <ul id="cartItems" class="list-group mb-3"></ul>
    <p class="fw-bold">Total: R$ <span id="cartTotal">0.00</span></p>
    <form method="POST" action="loja.php">
  <input type="hidden" name="finalizar" >
   <button  class="btn btn-success" onclick="checkout()">Finalizar Compra</button>
</form>
  </div>
</div>

<!-- Products -->
<div class="container">
  <div class="row g-4" id="productContainer">
    <!-- Produtos inseridos via JavaScript -->
  </div>
</div>

<script>
  const products = [
    {
      name: 'Figueira',
      price: 89.90,
      category: 'exterior',
      image: 'https://source.unsplash.com/300x300/?tree'
    },
    {
      name: 'Bonsai',
      price: 129.90,
      category: 'interior',
      image: 'https://source.unsplash.com/300x300/?bonsai'
    },
    {
      name: 'Ipê Amarelo',
      price: 99.00,
      category: 'exterior',
      image: 'https://source.unsplash.com/300x300/?yellow-tree'
    },
    {
      name: 'Samambaia',
      price: 39.00,
      category: 'interior',
      image: 'https://source.unsplash.com/300x300/?fern'
    }
  ];

  let cart = [];

  const container = document.getElementById("productContainer");
  const search = document.getElementById("filterSearch");
  const category = document.getElementById("filterCategory");
  const price = document.getElementById("filterPrice");

  function renderProducts(list) {
    container.innerHTML = "";
    if (list.length === 0) {
      container.innerHTML = "<p class='text-center'>Nenhuma árvore encontrada.</p>";
      return;
    }
    list.forEach(p => {
      container.innerHTML += `
        <div class="col-md-3 animate-fade">
          <div class="card product-card h-100 d-flex flex-column justify-content-between">
            <img src="${p.image}" class="card-img-top" alt="${p.name}">
            <div class="card-body text-center">
              <h5 class="card-title">${p.name}</h5>
              <p class="card-text text-success">R$ ${p.price.toFixed(2)}</p>
              <a href="detalhes.html?tree=${p.name}" class="btn btn-primary btn-sm">Ver Detalhes</a>
              <button class="btn btn-primary btn-sm" onclick="addToCart('${p.name}')">Adicionar ao Carrinho</button>
            </div>
          </div>
        </div>
      `;
    });
  }

  function filterProducts() {
    let searchText = search.value.toLowerCase();
    let selectedCategory = category.value;
    let selectedPrice = price.value;

    let filtered = products.filter(p => {
      const matchSearch = p.name.toLowerCase().includes(searchText);
      const matchCategory = selectedCategory ? p.category === selectedCategory : true;
      const matchPrice =
        selectedPrice === "1" ? p.price <= 50 :
        selectedPrice === "2" ? p.price > 50 && p.price <= 100 :
        selectedPrice === "3" ? p.price > 100 : true;

      return matchSearch && matchCategory && matchPrice;
    });

    renderProducts(filtered);
  }

  function toggleCart() {
    const cartDiv = document.getElementById("cart");
    cartDiv.classList.toggle("open");
  }

  function addToCart(name) {
    const product = products.find(p => p.name === name);
    cart.push(product);
    updateCart();
  }

  function updateCart() {
    const cartList = document.getElementById("cartItems");
    const cartTotal = document.getElementById("cartTotal");
    const cartCount = document.getElementById("cartCount");

    cartList.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
      total += item.price;
      const li = document.createElement("li");
      li.className = "list-group-item d-flex justify-content-between align-items-center";
      li.innerHTML = `
        ${item.name} - R$ ${item.price.toFixed(2)}
        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">✕</button>
      `;
      cartList.appendChild(li);
    });

    cartTotal.textContent = total.toFixed(2);
    cartCount.textContent = cart.length;
  }

  function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
  }

  function checkout() {
    if (cart.length === 0) {
      alert("Seu carrinho está vazio!");
      return;
    }
    
    alert("Compra finalizada! Obrigado por plantar uma árvore 🌱");
    cart = [];
    updateCart();
    toggleCart();
    
  }

  // Event listeners
  search.addEventListener("input", filterProducts);
  category.addEventListener("change", filterProducts);
  price.addEventListener("change", filterProducts);

  // Inicializa
  renderProducts(products);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
