export default (doc, address, startY, fontSize, lineSpacing) => {

    let startX = 57;
    const spaceBetweenWords = 8;

    //-------Sender Info Draw Line and Graphic---------------------
    let endX = doc.internal.pageSize.width - startX;
    doc.setLineWidth(0.5);
    doc.line(startX, startY + lineSpacing / 2, endX, startY + lineSpacing / 2);

    //-------Sender Info Address---------------------
    doc.setFontSize(fontSize);

    address = Object.values(address);
    // @todo: more dynamic slice arrays
    const pageWidth = doc.internal.pageSize.width;
    const pageCenterX = pageWidth / 2;

    // Report Name //   
    doc.setFontSize(17);
    doc.setFontType('bold');
    var text = address[0],
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / 2);
    doc.text(text, xOffset, 22);


    // Address //   
    doc.setFontSize(8);
    doc.setFontType('bold');
    var addressDisplay = address[1] + ', ' + address[2],
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(addressDisplay) * doc.internal.getFontSize() / 2);
    doc.text(addressDisplay, xOffset, 32);


    // Contact //   
    doc.setFontSize(8);
    doc.setFontType('bold');
    var addressDisplay = 'Tel ' + address[3] + '  Email ' + address[4],
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(addressDisplay) * doc.internal.getFontSize() / 2);
    doc.text(addressDisplay, xOffset, 42);


    // Report Name //   
    doc.setFontSize(14);
    doc.setFontType('bold');
    doc.addFont('ComicSansMS', 'Comic Sans', 'normal');
    doc.setFont('Comic Sans');
    var addressDisplay = address[5],
        xOffset = (doc.internal.pageSize.width / 2) - (doc.getStringUnitWidth(addressDisplay) * doc.internal.getFontSize() / 2);
    doc.text(addressDisplay, xOffset, 56);

    doc.setFont('WorkSans');


    const addressStart = address.slice(0, 3);
    const addressEnd = address.slice(3);

    addressStart.map(text => {
        if (text) {
            doc.setFontSize(fontSize);
            doc.setFontType('normal');
            doc.text(text, startX, startY);
            startX = startX + doc.getStringUnitWidth(text) * fontSize + spaceBetweenWords;
        }
    });

    addressEnd.map(text => {
        if (text) {
            console.log(endX);
            console.log(startY);
            doc.text(text, endX, startY, 'right');
            endX = endX - doc.getStringUnitWidth(text) * fontSize - spaceBetweenWords;
        }
    });

    return startY;
};

