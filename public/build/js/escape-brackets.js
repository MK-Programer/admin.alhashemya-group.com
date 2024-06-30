function escapeBrackets(id){
    return id.replace(/([\[\]])/g, '\\$1');
}