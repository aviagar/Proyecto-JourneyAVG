<!DOCTYPE html>
<html lang="en">

<body>
    <div class="header">

        <div class="titulo">
            <span id="titulo">Elige tu plan</span>
        </div>
    </div>

    <main>
        <div class="pagoFormulario" id="divSobreNosotros">
            <span class="subrayadoNegro">Plan basico</span>
            <div class="pagoInput">
                <p>
                    El plan básico de reserva de coche incluye el alquiler de un único vehículo con seguro básico,
                    que cubre daños esenciales pero puede tener franquicia. Ofrece un kilometraje estándar y asistencia
                    en carretera 24 horas para mayor tranquilidad durante el viaje. Además, permite la cancelación gratuita
                    si se realiza con al menos 24 horas de antelación al inicio del periodo de alquiler.
                    Es una opción ideal para quienes buscan una solución sencilla, económica y segura para desplazamientos puntuales.
                </p>
            </div>
            <form action="src/seleccionar_plan.php" method="post">
                <button type="submit" name="plan" value="basico" class="aeropuerto-b">Seleccionar plan</button>
            </form>

            <span class="subrayadoNegro">Plan extra</span>
            <div class="pagoInput">
                <p>
                    El plan extra de reserva ofrece el alquiler de un solo coche con un seguro ampliado que reduce la franquicia
                    en caso de daños, ideal para quienes buscan mayor tranquilidad. Incluye kilometraje ilimitado, asistencia en
                    carretera 24h y prioridad en la atención al cliente. Además, permite modificar la reserva sin coste adicional
                    hasta 24 horas antes del inicio del alquiler. Es una opción equilibrada para viajes más largos o usuarios
                    que valoran mayor flexibilidad y cobertura.
                </p>
            </div>
            <form action="src/seleccionar_plan.php" method="post">
                <button type="submit" name="plan" value="extra" class="aeropuerto-b">Seleccionar plan</button>
            </form>

            <span class="subrayadoNegro">Journey Swap</span>
            <div class="pagoInput">
                <p>
                    El plan Journey Swap es la opción premium para quienes buscan máxima flexibilidad y ventajas exclusivas.
                    Durante el periodo de alquiler, si el cliente desea cambiar el coche por cualquier otro modelo disponible, solo tiene que acercarse a una sucursal y solicitar el cambio, sujeto a disponibilidad.
                    Este plan permite adaptarse a diferentes momentos del viaje sin complicaciones. Además, ofrece seguro a todo riesgo sin franquicia, kilometraje ilimitado, asistencia en carretera prioritaria, atención preferente 24/7 y opción de devolución flexible en distintas ubicaciones.
                    Es la opción ideal para viajeros exigentes que desean libertad total y una experiencia sin límites.
                </p>
            </div>
            <form action="src/seleccionar_plan.php" method="post">
                <button type="submit" name="plan" value="journeySwap" class="aeropuerto-b">Seleccionar plan</button>
            </form>

        </div>

    </main>
    </div>
</body>

</html>