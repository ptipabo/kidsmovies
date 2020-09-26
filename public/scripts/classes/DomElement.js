export default class DomElement{

    addElement(tagName = null, tagParams = [], paramsValues = []){
        if(tagName === null || tagName === undefined){
            console.log("addElement() => ERROR : tagName is not defined !")
        }else{
            let newElement = document.createElement(tagName)
            if(tagParams.length === paramsValues.length){
                for(y=0;y<tagParams.length;y++){
                    if(tagParams[y] !== ''){
                        newElement[tagParams[y]] = paramsValues[y]
                    }
                }
            }else{
                console.log("addElement() => ERROR : the number of parameters doesn't match the number of parameters values !")
            }
    
            return newElement;
        }
    }

    /*constructor(id){
        this.element = document.getElementById(id)
        this.elementClasses = element.classList.split(' ');
    }

    getClass(classNumber = null){
        if(classNumber === null){
            return this.elementClasses
        }
        else{
            return this.elementClasses[classNumber]
        }
    }

    addClass(className){
        this.element.classList.add(className)
    }

    removeClass(className){
        this.element.classList.remove(className)
    }*/
}