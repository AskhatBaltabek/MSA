function downloadFile(filename, href) {
    let downloadLink = document.createElement("a");
    downloadLink.href = href;
    downloadLink.download = filename;

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

export { downloadFile }