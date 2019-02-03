//module for making ajax request -> only json data is accepted
//accepts { url: destination, method: post/get, data: data object }
export class XhrRequest{
  static make(reqObj){
    return new Promise( (resolve,reject) => {
      try{
        if(!reqObj.url){
          return new Error('no destination url defined');
        }
        else{
          let timeStamp = new Date().getTime();
          let url = `${ reqObj.url }?ts=${ timeStamp } `;
          let method = (reqObj.method) ? reqObj.method : 'get';
          let payload = JSON.stringify(reqObj.data);
          
          let request = new XMLHttpRequest();
          request.open( method, url );
          request.setRequestHeader('Content-Type', 'application/json');
          request.addEventListener('load', (response) => {
            console.log(response);
          });
          request.send(payload);
        }
      }
      catch(error){
        reject(error);
      }
    });
  }
}


// export class XhrRequest{
//   constructor(url,method){
//     let ts = new Date().getTime();
//     this.url = `${url}?ts=${ts} `;
//     this.method = (method == 'post')? 'post' : 'get';
//   }
//   async make( payload ){
//     let req = new XMLHttpRequest();
//     req.open( this.method, this.url );
//     req.setRequestHeader('Content-Type', 'application/json');
//     req.addEventListener('load', (event) => {
//       //do something when complete
//       return (req.responseText);
//     });
//     req.addEventListener('error', ( error ) => {
//       //do something when an error occurs
//       return (error);
//     });
//     req.send( payload );
//   }
// }