class RegistryForm extends React.Component{
    constructor(){
        super();
        this.state ={
            type: true,
            alert:false,
            show: false,
            values: {
                login:'',
                email:'',
                password:''
            }
        }
    }
    onChange = (e) =>{
        const _event = event.currentTarget;
        
        this.setState(prevState => ({values:{...prevState.values,[_event.name]:_event.value}}),()=>{ 
            val = {
                action: 'validate',
                items:{
                    name: e.name,
                    value: this.state.values[name]
                } 
            };
            this.send(val)}
        );
    }
    register = () =>{
        reg = {
            action: 'registry',
            items: this.state.values
        }
        this.send(reg);
    }
    send = (data_object) =>{
        const object = JSON.stringify(data_object);
        fetch("src/controller.php",{
			method: 'post',
			body: object
		})
      		.then(res => res.json())
      		.then(
        		(result) => {
					  console.log(result);
          			},
        		
        		(error) => {
					this.setState(prevState=> ({loading: {...prevState.loading, [name]: false}})),
					error
				}
			  )

    } 
    render(){
        return(
            <form>
                <div className="row-form">
                    <InputReg name="login" type="text" placeholder="Login" onChange={this.onChange.bind(this)}/> 
                    {this.state.alert ? <Alert /> : ''}     
                </div>
                <div className="row-form">
                    <InputReg name="email" type="text" placeholder="Email" onChange={this.onChange.bind(this)}/>      
                    {this.state.alert ? <Alert /> : ''}
                </div>
                <div className="row-form">
                    <InputReg name="password" type={this.state.type ? "password" : "type"} placeholder="Hasło" onChange={this.onChange.bind(this)}/>      
                    {this.state.alert ? <Alert /> : ''}
                </div>
                <div className="row-form">
                    <InputReg name="repassword" type={this.state.type ? "password" : "type"} placeholder="Powtórz hasło" onChange={this.onChange.bind(this)}/>      
                    {this.state.alert ? <Alert /> : ''}
                </div>
            </form>
        );
    }

}
class InputReg extends React.Component{
    render(){
        return(
            <input name={this.props.name} type={this.props.type} placeholder={this.props.placeholder} onChange={this.props.onChange}></input>
        );
    }
}
class RegBtn extends React.Component{
    render(){
        return(
            <button onClick={this.props.reg}>Zarejestruj</button>
        );
    }
}
class Alert extends React.Component{
    render(){
        return(
            <span>{this.props.alert}</span>
        );
    }
}