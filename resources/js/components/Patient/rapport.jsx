import React from "react";
import Intervention from '../props/Patient/Rapport/Intervention';
import Facturation from "../props/Patient/Rapport/Facturation";
import Informations from "../props/Patient/Rapport/Informations";
import ATA from "../props/Patient/Rapport/ATA";
import axios from "axios";
import PagesTitle from "../props/utils/PagesTitle";
import PermsContext from "../context/PermsContext";

class Rapport extends React.Component{

    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.state = {
            name: "",
            tel: "",
            type: 0,
            transport: 1,
            desc: '',
            montant: null,
            payed: true,
            startdate: '',
            starttime: '',
            enddate: '',
            endtime: '',
            pdf: null,
            error: false,
            succsess: false,
            req: null,
            startinter: '',
        }
    }

    async handleSubmit(event) {
        console.log(this.state.startdate)
        event.preventDefault();
        var req = await axios({
            url: '/data/rapport/post',
            method: 'POST',
            data: {
                name: this.state.name,
                startinter: this.state.startinter,
                tel: this.state.tel,
                type: this.state.type,
                transport: this.state.transport,
                desc: this.state.desc,
                montant: this.state.montant,
                payed: this.state.payed,
                startdate: this.state.startdate,
                starttime: this.state.starttime,
                enddate: this.state.enddate,
                endtime: this.state.endtime,
            }
        })

        if(req.status === 201){
            this.setState({succsess: true,req: req,
                name: "",
                startinter: '',
                tel: "",
                type: 0,
                transport: 1,
                desc: '',
                montant: 0,
                payed: true,
                startdate: '',
                starttime: '',
                enddate: '',
                endtime: '',});

        }else{
            this.setState({error: true});
        }

    }

    render() {
        let perm = this.context;
        return(
            <div id={'Rapport-Patient'}>
                <form method={'POST'} onSubmit={this.handleSubmit}>
                <div className={'Header'}>
                    <div className={"submit"}>
                        {perm.rapport_create &&
                            <button type={"submit"} > Enregistrer</button>
                        }
                        {!perm.rapport_create &&
                            <button type={"submit"} disabled> Enregistrer</button>
                        }
                    </div>
                    <PagesTitle title={'Rapport patient'}/>
                </div>
                <div className={'content'}>

                        <Informations name={this.state.name} startinter={this.state.startinter} tel={this.state.tel} onStartChange={(str)=>{this.setState({startinter:str})}} onNameChange={(str) =>{this.setState({name:str});}} onTelChange={(str) =>  {this.setState({tel:str});}}/>
                        <Intervention type={this.state.type} transport={this.state.transport} description={this.state.desc} onTypeChange={(str) =>{this.setState({type:str});}} onTransportChange={(str) => {this.setState({transport:str});}} onDescChange={(str) => {this.setState({desc:str});}}/>
                        <Facturation payed={this.state.payed} montant ={this.state.montant} onPayedChange={(str) => {this.setState({payed:str});}} onMotantChange={(str) => {this.setState({montant:str});}}/>
                        <ATA startDate={this.state.startdate} startTime={this.state.starttime} endDate={ this.state.enddate} endTime={ this.state.endtime} onStartDateChange={(str) => {this.setState({startdate:str});}} onStartTimeChange={(str) => {this.setState({starttime:str});}} onEndDateChange={(str) => {this.setState({enddate:str});}} onEndTimeChange={(str) => {this.setState({endtime:str});}}/>
                </div>
                </form>
            </div>
        );
    }
}
Rapport.contextType = PermsContext;
export default Rapport