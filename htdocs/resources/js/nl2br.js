 const nl2br = str => {
    let res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");

    return res;
}

export default nl2br;