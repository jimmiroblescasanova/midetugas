## Todos los recibos

--- 

- [Tabla de recibos](#documents-table)
- [Ver / Editar recibo: Info](#info-document)
- [Ver / Editar recibo: Menú](#edit-document)

<a name="documents-table"></a>
## Tabla de recibos 

<img alt="Tabla de recibos" src="/documentation/documents_table.png" width="500">

Aquí se muestra la lista de todos los recibos que se han ido generando, de igual forma su estado actual y la opción para verlos individualmente.
- **Pendiente**: En este momento el recibo aún no se ha completado, está disponible para su validación. Aún no se ha enviada nada a los clientes. 
- **Autorizado**: A partir de este momento el documento ya está enviado al cliente. Y se documentó la deuda del cliente. 
- **Cancelado**: En este momento el documento deja de contar para el cliente.
- **Pagado**: Cuando el cliente realiza el pago de su recibo.

<a name="info-document"></a>
## Ver / Editar recibo: Info

<img alt="Información del documento" src="/documentation/show_document_info.png" width="500">

Aquí se muestra la información del documento creado. 
También una gráfica que muestra los consumos que ha tenido en meses anteriores. 
A la derecha se muestra la imagen del medidor capturado. 

<a name="edit-document"></a>
## Ver / Editar recibo: Menú

<img alt="Menú" src="/documentation/show_document_menu.png" width="500">

Este es el menú con las opciones de cada documento: 
    - **Autorizar**: Cambiar el estado del documento a autorizado y envía la información al cliente por correo electrónico.
    - **Cancelar**: Cancela el documento y regresa la información a su estado anterior. 
    - **CTiComercial**: Envía la información del documento al sistema comercial. 
    - **Imprimir**: Muestra la representación impresa del documento en PDF. 

> {warning} Un documento pagado, no se puede cancelar. Se deberá cancelar el pago para poder realizar el proceso. 
