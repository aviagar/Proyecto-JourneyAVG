<!DOCTYPE html>
<html lang="en">
</head>



<body>
    <div class="header">

        <div class="titulo">
            <span id="titulo">Termina tu reserva</span>
        </div>
    </div>

    <main>
        <div class="pagoFormulario">
            <h3 class="pagoTitulo">¿Con qué tarjeta de crédito desea pagar?</h3>
            <form method="POST" action="src/procesar_reserva.php" id="formPago">
                <!-- Número de tarjeta -->
                <input type="text" class="pagoInput" name="numero_tarjeta" placeholder="Número de la tarjeta"
                    pattern="^\d{13,19}$" title="Debe contener entre 13 y 19 dígitos sin espacios ni guiones." required>
                <span class="error-message"></span>

                <!-- Nombre del titular -->
                <input type="text" class="pagoInput" name="nombre_titular" placeholder="Nombre del titular de la tarjeta"
                    pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ ]{3,50}$" title="Solo letras y espacios, entre 3 y 50 caracteres." required>
                <span class="error-message"></span>

                <!-- Fecha y CVV -->
                <div class="pagoFila">
                    <input type="text" class="pagoInput" name="fecha_expiracion" placeholder="Fecha de expiración (MM/YY)"
                        pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Formato válido: MM/YY, ejemplo: 09/24" required>
                    <span class="error-message"></span>

                    <input type="text" class="pagoInput" name="cvv" placeholder="CVV"
                        pattern="^\d{3,4}$" title="Debe contener 3 o 4 dígitos." required>
                    <span class="error-message"></span>
                </div>

                <!-- Dirección de facturación -->
                <h3 class="pagoTitulo">¿Dónde debemos enviar la factura?</h3>
                <div class="pagoFila">
                    <input type="text" class="pagoInput" name="pais" placeholder="País"
                        pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ ]{2,20}$" title="Solo letras y espacios, mínimo 2 caracteres." required>
                    <span class="error-message"></span>

                    <input type="text" class="pagoInput" name="codigo_postal" placeholder="Código Postal"
                        pattern="^\d{4,10}$" title="Entre 4 y 10 números." required>
                    <span class="error-message"></span>
                </div>

                <input type="text" class="pagoInput" name="direccion" placeholder="Dirección"
                    pattern="^[A-Za-z0-9ÁÉÍÓÚÑáéíóúñ.,\- ]{5,100}$" title="Dirección válida, mínimo 5 caracteres." required>
                <span class="error-message"></span>

                <input type="text" class="pagoInput" name="ciudad" placeholder="Ciudad"
                    pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ ]{2,30}$" title="Solo letras y espacios, mínimo 2 caracteres." required>
                <span class="error-message"></span>

                <input type="text" class="pagoInput" name="provincia" placeholder="Provincia"
                    pattern="^[A-Za-zÁÉÍÓÚÑáéíóúñ ]{2,30}$" title="Solo letras y espacios, mínimo 2 caracteres." required>
                <span class="error-message"></span>

                <!-- Total (opcional si solo es visual) -->
                <div class="pagoTotal">
                    <strong>Total:</strong> <span class="pagoCantidad">000,00€</span>
                </div>

                <div class="contenedorCentrado">
                    <button type="submit" class="botonConfirmar">Aceptar</button>
                </div>
            </form>

        </div>


    </main>

    </div>
</body>


</html>