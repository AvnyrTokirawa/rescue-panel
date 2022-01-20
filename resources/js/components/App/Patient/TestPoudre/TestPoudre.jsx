import React, {useState} from 'react';
import CardComponent from "../../../props/CardComponent";
import axios from "axios";
import SwitchBtn from "../../../props/SwitchBtn";
import Searcher from "../../../props/Searcher";
import PageNavigator from "../../../props/PageNavigator";

function TestPoudre(props) {
    const [name, setName] = useState();
    const [ddn , setDDn] = useState();
    const [tel, setTel] = useState();
    const [liveplace, setLiveplace] = useState();
    const [prevPlace, setPrevPlace] = useState();
    const [searching, setsearching] = useState();
    const [patient, setpatient] = useState();
    const [skinPresence, setSkinPresence] = useState(false);
    const [clothPresence, setClothPresence] = useState(false);
    const [search, setSearch] = useState();

    const searchPatient = async (search) => {
        if(search.length > 0){
            await axios({
                method: 'GET',
                url: '/data/patient/search/'+search,
            }).then((response)=>{
                setsearching(response.data.patients);
                if (response.data.patients.length === 1) {
                    let patient = response.data.patients[0];
                    setName(patient.vorname + ' ' + patient.name);
                    setDDn(patient.naissance);
                    setTel(patient.tel);
                    setLiveplace(patient.living_place);
                }
                if (response.data.patients.length === 0) {
                    setName('');
                    setDDn('');
                    setTel('');
                    setLiveplace('');
                }

            })
        }
    }

    return (<div className={'testPoudre'}>
        <section className={'makeTest'}>
            <CardComponent title={'test de poudre'}>
                <section className={'test-component'}>
                    <section className={'patientInfos'}>
                        <div className={'form-item form-column'}>
                            <label>prénom nom</label>
                            <input type={'text'} className={'form-input'} list={'autocomplete'} value={name} onChange={(e)=>{setName(e.target.value), searchPatient(e.target.value)}}/>
                            {searching &&
                                <datalist id={'autocomplete'}>
                                    {searching.map((item)=>
                                        <option key={item.id}>{item.vorname} {item.name}</option>
                                    )}
                                </datalist>
                            }
                            <div className={'errors-list'}>
                                <ul>
                                    <li>test</li>
                                </ul>
                            </div>
                        </div>
                        <div className={'form-item form-column'}>
                            <label>date de naissance</label>
                            <input type={'date'} className={'form-input'} value={ddn} onChange={(e)=>{setDDn(e.target.value)}}/>
                            <div className={'errors-list'}>
                                <ul>
                                    <li>test</li>
                                </ul>
                            </div>
                        </div>
                        <div className={'form-item form-column'}>
                            <label>téléphone</label>
                            <input type={'text'} className={'form-input'} value={tel} onChange={(e)=>{setTel(e.target.value)}}/>
                            <div className={'errors-list'}>
                                <ul>
                                    <li>test</li>
                                </ul>
                            </div>
                        </div>
                        <div className={'form-item form-column'}>
                            <label>Lieux de vie</label>
                            <input type={'text'} className={'form-input'} value={liveplace} onChange={(e)=>{setLiveplace(e.target.value)}}/>
                            <div className={'errors-list'}>
                                <ul>
                                    <li>test</li>
                                </ul>
                            </div>
                        </div>


                    </section>
                    <section className={'poudre'}>
                        <div className={'form-item form-column'}>
                            <label>Lieux de prélèvement</label>
                            <input type={'text'} className={'form-input'} value={prevPlace} onChange={(e)=>{setPrevPlace(e.target.value)}}/>
                            <div className={'errors-list'}>
                                <ul>
                                    <li>test</li>
                                </ul>
                            </div>
                        </div>
                        <h2>Présence de poudre</h2>
                        <div className={'poudre-presence'}>
                            <label>Sur la peau</label>
                            <SwitchBtn number={'A0'} checked={skinPresence} callback={()=>{setSkinPresence(!skinPresence)}}/>
                        </div>
                        <div className={'poudre-presence'}>
                            <label>Sur les vètements</label>
                            <SwitchBtn number={'A0'} checked={clothPresence} callback={()=>{setClothPresence(!clothPresence)}}/>
                        </div>
                    </section>
                </section>
                <section className={'footer'}>
                    <button className={'btn'}>valdier</button>
                </section>
            </CardComponent>

        </section>
        <section className={'test-table'}>
            <div className={'table-header'}>
                <Searcher value={search} callback={(v) => {setSearch(v)}}/>
                <PageNavigator/>
            </div>
            <div className={'table-content'}>
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>prénom nom</th>
                        <th>peau</th>
                        <th>vêtements</th>
                        <th>pdf</th>
                        <th>date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jean claude</td>
                        <td><img src={'/assets/images/accept.png'} alt={''}/></td>
                        <td><img src={'/assets/images/decline.png'} alt={''}/></td>
                        <td><button className={'btn'}><img src={'/assets/images/pdf.png'} alt={''}/></button> </td>
                        <td>14/01 13h20</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Jean claude</td>
                        <td><img src={'/assets/images/decline.png'} alt={''}/></td>
                        <td><img src={'/assets/images/decline.png'} alt={''}/></td>
                        <td><img src={'/assets/images/pdf.png'} alt={''}/></td>
                        <td>14/01 13h20</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>)
}

export default TestPoudre;