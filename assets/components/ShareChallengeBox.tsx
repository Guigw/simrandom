import {FocusEvent, useEffect, useState} from "react";
import {DefaultApi, ResultsChallenge} from "../gen";
import {Card, Dialog, DialogTitle, TextField} from "@mui/material";
import {makeStyles} from '@mui/styles';
import * as React from "react";
import IconButton from "@mui/material/IconButton";
import AssignmentReturnedIcon from '@mui/icons-material/AssignmentReturned';
import AssignmentTurnedInIcon from '@mui/icons-material/AssignmentTurnedIn';
import CircularProgress from "@mui/material/CircularProgress";

type ShareChallengeBoxProps = {
    api: DefaultApi,
    getResultChallenge: () => ResultsChallenge
    open: boolean;
    onClose: () => void
}

const useStyles = makeStyles((theme?: any) =>
    ({
        root: {
            '& .MuiTextField-root': {
                margin: theme.spacing(1),
                width: 525,
            },
            '& .MuiCard-root': {
                display: 'flex',
                alignItems: 'center',
            }
        },
    })
);

const ShareChallengeBox = ({api, getResultChallenge, open, onClose}: ShareChallengeBoxProps) => {

    interface linkResults {
        resultList: Array<number>,
        link: string
    }

    const [link, setLink] = useState<linkResults | null>(null);
    const [copied, setCopied] = useState<boolean>(false);
    const classes = useStyles();

    useEffect(() => {
        let mount = true;
        if (open) {
            const resultChallenge = getResultChallenge();
            if (!link || !equals(resultChallenge.resultList, link.resultList)) {
                api.challengeSavePost(resultChallenge).then(saved => {
                    if (mount) {
                        setLink({
                            resultList: resultChallenge.resultList,
                            link: window.location.origin + '/challenge/' + saved.id
                        })
                    }
                })
            }
        }

        return () => {
            mount = false
        }
    }, [open, link])

    const equals = (a: Array<number>, b: Array<number>) => JSON.stringify(a) === JSON.stringify(b);

    const handleClose = () => {
        setCopied(false);
        onClose();
    };

    const copyLinkToClip = () => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(link.link)
                .then(() => {
                    setCopied(true);
                })
                .catch(err => {
                    console.log('Something went wrong', err);
                })
        }
    }

    const onFocusField = (event: FocusEvent<HTMLInputElement>) => {
        event.currentTarget.select();
    }

    return (
        <Dialog className={classes.root} onClose={handleClose} open={open}
                aria-labelledby="simple-dialog-title"
                fullWidth={true}>
            <DialogTitle id="simple-dialog-title">Copy this link</DialogTitle>
            <Card>
                {link &&
				<TextField id="link-copy-field" label="Link" value={link?.link} variant="filled" inputProps={
                    {readOnly: true, "aria-label": 'sharing link'}
                } onFocus={onFocusField}/>
                }
                {(link && !copied) &&
				<IconButton aria-label="copy" onClick={copyLinkToClip} size="large">
					<AssignmentReturnedIcon/>
				</IconButton>
                }
                {(link && copied) &&
				<IconButton aria-label="copy" size="large">
					<AssignmentTurnedInIcon/>
				</IconButton>
                }
                {!link &&
				<CircularProgress color="inherit"/>
                }
            </Card>
        </Dialog>
    );
}

export default ShareChallengeBox