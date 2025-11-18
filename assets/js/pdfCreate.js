async function pdfCreate(){
    const rentDetails = document.getElementById("rent-details");
    const date = new Date();

    var archivoPDF = new PDF24Doc();
    archivoPDF.setCharset("UTF-8");
    archivoPDF.setFilename("FacturaFarmXpress.pdf");
    archivoPDF.setPageSize(210, 297);

    var contenidoPDF = new PDF24Element();
    contenidoPDF.setTitle("Factura de Alquiler");
    contenidoPDF.setUrl("http://www.pdf24.org");
    contenidoPDF.setAuthor("FarmXPress");
    contenidoPDF.setDateTime(date.getTime());
    var texto=rentDetails.innerHTML
    contenidoPDF.setBody(texto);
    archivoPDF.addElement(contenidoPDF);

    archivoPDF.create();
}