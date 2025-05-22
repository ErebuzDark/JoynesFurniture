<style>
.color{
    margin-bottom: 100px;
}
.clear{
    margin-right: 170px;
}
 .drop {
    background: #eee;
    max-width: 500px;
    height: 500px;
    width: 100%;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    color: #999;
    cursor: pointer;
    border: 2px dashed #ccc;
    position: relative;
    overflow: hidden;
}
.icon {
    font-size: 100px;
    margin-bottom: 16px;
}
h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 16px;
    pointer-events: none;
}
p {
    font-size: 14px;
}
p span {
    font-weight: 600;
}
.thumbnail, .img-name {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}
.thumbnail {
    object-fit: cover;
    z-index: 100;
}
.img-name {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-weight: 500;
    padding: 16px;
    background: rgba(0, 0, 0, .5);
    z-index: 200;
    opacity: 0;
    transition: all .3s ease;
}
.drop-area:hover .img-name {
    opacity: 1;
}
.btns{
    margin-top: 100px;
}
.colortitle{
    color: black;
    margin-bottom: 50px;
}
.img1, 
.img2{
    border-radius: 50% ;
}
.container{
    justify-content: space-between;
}
.container-btns{
    width: 100%;
    margin: 0;
}
.input_wood input:checked + img ,
.input_var input:checked + img
{
    border: 2.5px solid black;
}


.input_hidden{
    display: none;
}
.container-btn{
    margin-left: 100px;
}
.btn{
    border:  1px solid;
}
.btn:hover{
    background-color: #dbb588;
    border: 1px solid;
}
</style>