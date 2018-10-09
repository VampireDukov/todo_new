class Form extends React.Component {
    constructor(){
        super();
        this.state = {
            login: '',
            password: '',
            host:'',
            base:'',
            type:false,
            button:false,
            install:false,
            loading:'Zainstaluj!',
            loader:false
        
        }
    }
    onChange = (event) =>{
        const _event = event.currentTarget;
        console.log(_event.name);
	    	this.setState({[_event.name]:_event.value}, ()=>this.notNull(this.state));
       
		
    }
    showPass = () =>{
        this.setState(state => ({
            type: !state.type
          }));
    }
    notNull(){
        for(var o in this.state){
            if(this.state[o] === ''){
             this.setState({button: false});
             return false;   
            }
        }	  
        this.setState({button:true});
    }
    sendItems = (e) =>{
        e.preventDefault();
        this.setState({loader:true});
        var items = new Object();
        for (let i in this.state){
            if(i != 'button' && i!='type'){
                items[i] = this.state[i]; 
            }
        }
		items = JSON.stringify(items);
		console.log(typeof items);
		const object_items = new FormData();
		object_items.append("action","install");
		object_items.append('items',  items);
		fetch("src/backend/controller.php",{
			method:'post',
			body: object_items
		})
			.then(res=>res.json())
			.then(
				(result)=>{
                    if(result){
                        if(result){
                            location.reload();
                        }        
                    }
                    else{
                        this.setState({loader:false,loading:'Coś poszło nie tak!'});
                    }
				},
				(error) => {
                    this.setState({loader:false,loading:'Coś poszło nie tak!'},()=>{setTimeout(()=>{this.setState({loading:'Instaluj!'})},1000 )}),
					error
				}
			)
	}
    render(){
        return( 
            <React.Fragment>
               <Header /> 
            <form>
                <div className='form-row'>
                    <Input type="text" placeholder="Login do bazy danych" name="login" className="install" onChange={this.onChange.bind(this)}/>
                </div>
                <div className='form-row'>
                    <Input type={ this.state.type ?  "text" : 'password'} placeholder="Hasło do bazy danych" name="password" className="install pass"  onChange={this.onChange.bind(this)}/>
                    <ShowPass onClick={this.showPass.bind(this)} />
                </div>
                <div className='form-row'>
                    <Input type="text" placeholder="Host bazy danych" name="host" className="install" onChange={this.onChange.bind(this)}/>
                </div>    
                <div className='form-row'>
                    <Input type="text" placeholder="Nazwa bazy danych" name="base" className="install" onChange={this.onChange.bind(this)}/>
                </div>
                <div className='form-row'>
                {this.state.button ? (
                    <Button className="form-btn" button={this.state.loader} text={this.state.loading} onClick={this.sendItems.bind(this)}/>
                 ) : (''
                )}
                </div>
            </form>
            </React.Fragment>
        )
    }
}    
class Input extends React.Component {
    constructor(){
        super();
    }
    render() {
        return (
            
                <input type={this.props.type} placeholder={this.props.placeholder} name={this.props.name} className={this.props.className} onChange={this.props.onChange}/>
        
      );
    }
  }
  class ShowPass extends React.Component{
      constructor(){
          super()
      }
      render(){
          return(
            <img className='show-pass-btn' src='src/frontend/modules/install/images/eye.png' onClick={this.props.onClick}/>
          );
      }
  }
  class Button extends React.Component{
        render(){
            return(
                <button className='send-button' onClick={this.props.onClick}>
                 {this.props.button ?  (<Loader/>) :(this.props.text)}
                </button>
            );
        } 
  }
  class Loader extends React.Component{
      render(){
          return(
              <img className='loader' src="src/frontend/modules/install/images/ajax-loader.gif"></img>
          );
      }
  }
  ReactDOM.render(
    <Form />,
    document.getElementById('app')
  );