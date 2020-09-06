class DomElement{

    constructor(id){
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
    }
}

export default DomElement;