class Header extends React.Component{
    constructor(){
        super();
        this.state = {
            type:true,
            registry: false,
            values:{
                login:'',
                password:''
            }
        }
    }
    onClick = (e)=>{
        e.preventDefault()
        this.setState(state => ({
            type: !state.type
          }));
    }
    login = (e) => {
        e.preventDefault();
        console.log('login');
    }
    registry = (e) =>{
        e.preventDefault();
        console.log('reg');
    }
    onChange = (event) =>{
        const _event = event.currentTarget;
        console.log(event.value);
        this.setState(prevState => ({values:{...prevState.values,[_event.name]:_event.value}}));
    }
    render(){
        return(
            <header>
                <h1>To Do</h1>
                <form>
                    <div className='row-form'>
                        <Input name="login" type="text" placeholder="Login lub Mail" onChange={this.onChange.bind(this)}/>
                    </div>
                    <div className="row-form">
                        <Input name="password" type={this.state.type ?  'password' : 'text'} placeholder="Hasło" onChange={this.onChange.bind(this)} />
                        <ShowButton onClick={this.onClick.bind(this)}/>
                        <SendButton onClick={this.login.bind(this)} log_reg="Zaloguj" />
                        <SendButton onClick={this.registry.bind(this)} log_reg="Zarejestruj" />
                    </div>
                </form>
            </header>
        );
    }
}
class Input extends React.Component{
    constructor(){
        super();
    }
    render(){
        return(
            <input name={this.props.name} type={this.props.type} placeholder={this.props.placeholder} className="login-poles" onChange={this.props.onChange}></input>
        );
    }
}
class ShowButton extends React.Component{
    render(){
        return(
            <img onClick={this.props.onClick} src="src/frontend/main/images/eye.png"></img>
        );
    }
}
class SendButton extends React.Component{
    render(){
        return(
            <button onClick={this.props.onClick}>{this.props.log_reg}</button>
        );
    }
}
ReactDOM.render(
    <React.Fragment>
		<Header />
        <RegistryForm />
    </React.Fragment>,  
	document.getElementById('app')
);